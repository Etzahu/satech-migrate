<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Rrhh\EmployeeSyncService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RrhhWebhookController extends Controller
{
    public function __construct(protected EmployeeSyncService $sync) {}

    /**
     * Recibe un webhook de colaboradores de rrhh. La firma ya fue
     * validada por el middleware; aquí solo se valida la forma del
     * sobre y se delega la sincronización al servicio.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'event' => ['required', 'string', 'in:employee.created,employee.updated,employee.deleted'],
            'data' => ['required', 'array'],
            'data.employee_id' => ['required', 'integer'],
        ]);

        $resultado = $this->sync->handle($request->input('event'), $request->input('data'));

        // Un conflicto no es un error de transporte: reintentar no lo arregla,
        // así que se responde 200 y se deja rastro para quien lo tenga que
        // resolver a mano.
        if ($resultado === EmployeeSyncService::CONFLICTO) {
            Log::warning('Webhook de rrhh sin aplicar: no se pudo confirmar a quién corresponde.', [
                'employee_id' => $request->input('data.employee_id'),
                'event' => $request->input('event'),
            ]);
        }

        return response()->json(['status' => 'ok', 'result' => $resultado], 200);
    }
}
