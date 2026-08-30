<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Rrhh\EmployeeSyncService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Endpoints que rrhh consume para ver y empujar el padrón de colaboradores de
 * este proyecto. La firma HMAC ya fue validada por el middleware
 * VerifyRrhhWebhookSignature, que firma el cuerpo crudo de la petición.
 *
 * Los dos son POST, incluso el inventario que sólo lee: la firma se calcula
 * sobre el cuerpo, así que un GET sin cuerpo tendría siempre la misma firma y
 * sería reutilizable para siempre por quien la capturara. Con un cuerpo que
 * trae `requested_at` cada petición se firma distinto y caduca.
 */
class RrhhUserController extends Controller
{
    /**
     * Margen de tolerancia de `requested_at`. Es amplio a propósito: los dos
     * proyectos viven en servidores distintos y un desfase de reloj de unos
     * minutos no debe tumbar la sincronización.
     */
    protected const TOLERANCIA_MINUTOS = 15;

    public function __construct(protected EmployeeSyncService $sync) {}

    /**
     * Padrón completo de colaboradores de este proyecto, normalizado al
     * contrato que rrhh espera de todos sus satélites.
     */
    public function inventory(Request $request): JsonResponse
    {
        $this->assertFreshRequest($request);

        $users = User::query()
            ->orderByDesc('id')
            ->get(['id', 'rrhh_employee_id', 'name', 'puesto', 'email', 'phone', 'active', 'updated_at']);

        return response()->json([
            'project' => config('app.name'),
            'generated_at' => now()->toIso8601String(),
            'counts' => [
                'total' => $users->count(),
                'active' => $users->where('active', true)->count(),
            ],
            'users' => $users->map(fn (User $user): array => [
                'id' => (int) $user->id,
                // Aquí el nombre vive en una sola columna; rrhh compara el
                // nombre completo, así que viaja entero en `first_name`.
                'first_name' => $user->name,
                'last_name' => null,
                'email' => $user->email,
                'phone' => $user->phone,
                'puesto' => $user->puesto,
                'area' => null,
                'depto' => null,
                'business_name_id' => null,
                'active' => (bool) $user->active,
                'active_raw' => (int) $user->active,
                'rrhh_employee_id' => $user->rrhh_employee_id !== null ? (int) $user->rrhh_employee_id : null,
                'updated_at' => $user->updated_at?->toIso8601String(),
            ])->values(),
        ]);
    }

    /**
     * Aplica el padrón que manda rrhh. Con `dry_run` se ejecuta el mismo
     * camino y se deshace al final: sirve para ver qué pasaría —sobre todo
     * qué conflictos hay— sin escribir nada.
     */
    public function sync(Request $request): JsonResponse
    {
        $this->assertFreshRequest($request);

        $request->validate([
            'employees' => ['present', 'array', 'max:500'],
            'employees.*.employee_id' => ['required', 'integer', 'min:1'],
            'deactivate' => ['sometimes', 'array', 'max:500'],
            'deactivate.*' => ['integer', 'min:1'],
            'dry_run' => ['sometimes', 'boolean'],
        ]);

        // Se lee del request y no del resultado de validate(): con reglas
        // anidadas, validate() sólo devuelve las llaves que se validaron y
        // dejaría cada colaborador reducido a su `employee_id`.
        $employees = $request->input('employees', []);
        $deactivate = $request->input('deactivate', []);
        $dryRun = $request->boolean('dry_run');

        if ($dryRun) {
            DB::beginTransaction();
        }

        try {
            $results = $this->sync->syncBatch($employees, $deactivate);
        } finally {
            if ($dryRun) {
                DB::rollBack();
            }
        }

        return response()->json([
            'project' => config('app.name'),
            'dry_run' => $dryRun,
            'processed' => count($results),
            'summary' => collect($results)
                ->countBy('resultado')
                // Un conflicto no es una divergencia de id: no se aplicó nada,
                // así que se cuenta aparte y no infla este número.
                ->put('id_divergente', collect($results)
                    ->reject(fn (array $result): bool => $result['resultado'] === EmployeeSyncService::CONFLICTO)
                    ->reject(fn (array $result): bool => $result['id_alineado'])
                    ->count())
                ->all(),
            'results' => $results,
        ]);
    }

    /**
     * Rechaza peticiones sin marca de tiempo o con una demasiado vieja: la
     * firma HMAC garantiza el origen, pero no impide que alguien reenvíe una
     * petición ya firmada.
     *
     * @throws ValidationException
     */
    protected function assertFreshRequest(Request $request): void
    {
        $request->validate([
            'requested_at' => ['required', 'date'],
        ]);

        $requestedAt = Carbon::parse($request->input('requested_at'));

        if ($requestedAt->diffInMinutes(now(), absolute: true) > self::TOLERANCIA_MINUTOS) {
            throw ValidationException::withMessages([
                'requested_at' => sprintf(
                    'La petición está fuera de la ventana de %d minutos (llegó %s, aquí son %s). Revisa el reloj de los servidores.',
                    self::TOLERANCIA_MINUTOS,
                    $requestedAt->toIso8601String(),
                    now()->toIso8601String(),
                ),
            ]);
        }
    }
}
