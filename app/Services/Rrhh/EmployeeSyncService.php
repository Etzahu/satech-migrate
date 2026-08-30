<?php

namespace App\Services\Rrhh;

use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Aplica sobre la tabla local `users` los colaboradores que manda rrhh.
 *
 * El punto delicado es a quién se le escribe. Los ids de esta base **no
 * siempre** son los de rrhh: parte del padrón se dio de alta aquí con su
 * propia secuencia, así que hay filas cuyo id pertenece, en rrhh, a otra
 * persona. Escribir a ciegas por id renombraría a alguien y dejaría sus
 * requisiciones firmadas por quien no fue. Por eso antes de escribir se
 * confirma la identidad, y cuando no se puede confirmar no se escribe: se
 * reporta el conflicto para que alguien lo resuelva.
 */
class EmployeeSyncService
{
    /** Alta nueva, con el mismo id que rrhh. */
    public const CREADO = 'creado';

    /** Se sobreescribieron los campos que rrhh manda. */
    public const ACTUALIZADO = 'actualizado';

    /** Baja local: el registro se conserva. */
    public const DESACTIVADO = 'desactivado';

    /** No hay a quién aplicarle el evento. */
    public const SIN_COINCIDENCIA = 'sin_coincidencia';

    /** No se pudo determinar con seguridad a quién escribirle. */
    public const CONFLICTO = 'conflicto';

    /**
     * Enruta cada evento del webhook de rrhh hacia la acción que le
     * corresponde sobre la tabla local `users`.
     *
     * @param  array<string, mixed>  $data
     */
    public function handle(string $event, array $data): string
    {
        return match ($event) {
            'employee.created', 'employee.updated' => $this->apply($data)['resultado'],
            'employee.deleted' => $this->deactivate($data),
            default => self::SIN_COINCIDENCIA,
        };
    }

    /**
     * Inserta o actualiza un colaborador.
     *
     * @param  array<string, mixed>  $data
     */
    public function upsert(array $data): ?User
    {
        return $this->apply($data)['user'];
    }

    /**
     * Igual que `upsert()`, pero devuelve el detalle de lo que ocurrió.
     *
     * `id_alineado` en falso significa que la persona vive aquí con un id
     * distinto al de rrhh: el registro queda correcto, pero el cruce por id
     * entre plataformas está roto para ella.
     *
     * @param  array<string, mixed>  $data
     * @return array{resultado: string, user: ?User, local_id: ?int, id_alineado: bool, motivo: ?string}
     */
    public function apply(array $data): array
    {
        $rrhhId = (int) $data['employee_id'];
        $hallazgo = $this->encontrar($data);

        if ($hallazgo['user'] === null && $hallazgo['motivo'] !== null) {
            return [
                'resultado' => self::CONFLICTO,
                'user' => null,
                'local_id' => null,
                'id_alineado' => false,
                'motivo' => $hallazgo['motivo'],
            ];
        }

        $user = $hallazgo['user'];
        $existia = $user !== null;

        if (! $existia) {
            $user = new User;

            // El id lo manda rrhh, no MySQL. Sin esto Eloquent inserta por la
            // vía autoincremental y sobreescribe el id en memoria con el
            // `lastInsertId()`, que es 0 cuando el id viajó explícito: la fila
            // queda bien pero el resultado reportado sale con id 0.
            $user->incrementing = false;
            $user->id = $rrhhId;
        }

        $user->forceFill($this->mapAttributes($data))->save();

        return [
            'resultado' => $existia ? self::ACTUALIZADO : self::CREADO,
            'user' => $user,
            'local_id' => (int) $user->id,
            'id_alineado' => (int) $user->id === $rrhhId,
            'motivo' => null,
        ];
    }

    /**
     * Un colaborador eliminado en rrhh se desactiva localmente en lugar de
     * borrarse, para no romper las referencias de otros registros que
     * apuntan a su `id`.
     *
     * @param  array<string, mixed>  $data
     */
    public function deactivate(array $data): string
    {
        $user = $this->encontrar($data)['user'];

        if ($user === null) {
            return self::SIN_COINCIDENCIA;
        }

        $user->forceFill(['active' => false])->save();

        return self::DESACTIVADO;
    }

    /**
     * Aplica de golpe el padrón que manda rrhh: alta o actualización de los
     * colaboradores del lote y baja de los ids que rrhh ya no considera
     * activos.
     *
     * Las bajas se resuelven sólo por vínculo (`rrhh_employee_id`) o por id:
     * a quien no está en rrhh no se le toca nunca.
     *
     * @param  array<int, array<string, mixed>>  $employees
     * @param  array<int, int>  $deactivateIds
     * @return array<int, array{employee_id: int, resultado: string, local_id: ?int, id_alineado: bool, motivo: ?string}>
     */
    public function syncBatch(array $employees, array $deactivateIds = []): array
    {
        $results = [];

        foreach ($employees as $employee) {
            $aplicado = $this->apply($employee);

            $results[] = [
                'employee_id' => (int) $employee['employee_id'],
                'resultado' => $aplicado['resultado'],
                'local_id' => $aplicado['local_id'],
                'id_alineado' => $aplicado['id_alineado'],
                'motivo' => $aplicado['motivo'],
            ];
        }

        foreach ($deactivateIds as $id) {
            $user = User::where('rrhh_employee_id', $id)->first() ?? User::find($id);

            $results[] = [
                'employee_id' => (int) $id,
                'resultado' => $user === null ? self::SIN_COINCIDENCIA : self::DESACTIVADO,
                'local_id' => $user !== null ? (int) $user->id : null,
                'id_alineado' => $user === null || (int) $user->id === (int) $id,
                'motivo' => null,
            ];

            $user?->forceFill(['active' => false])->save();
        }

        return $results;
    }

    /**
     * Decide a qué fila local le corresponde el colaborador, en orden de
     * confiabilidad. Devuelve `motivo` cuando no hay a quién escribirle con
     * seguridad y tampoco se puede crear.
     *
     * @param  array<string, mixed>  $employee
     * @return array{user: ?User, motivo: ?string}
     */
    protected function encontrar(array $employee): array
    {
        $rrhhId = (int) $employee['employee_id'];
        $nombreRrhh = $this->normalizar($this->nombreDelPayload($employee));
        $correoRrhh = $this->correoIdentificable($employee);

        // 1. Vínculo ya sellado: una vez resuelto, no se vuelve a adivinar.
        $sellado = User::query()->where('rrhh_employee_id', $rrhhId)->first();

        if ($sellado !== null) {
            return ['user' => $sellado, 'motivo' => null];
        }

        // 2. Mismo id, confirmando que es la misma persona por nombre o por
        // correo. Con el correo basta aunque el nombre no se parezca: cubre a
        // quien en rrhh se le corrigió el nombre completo. Si el payload no
        // trae ni nombre ni correo no hay con qué contradecir la identidad y se
        // acepta el id (los eventos de rrhh siempre traen nombre; los payloads
        // mínimos vienen de herramientas y de las pruebas).
        $porId = User::find($rrhhId);

        if ($porId !== null && $this->confirmaIdentidad($porId, $nombreRrhh, $correoRrhh)) {
            return ['user' => $porId, 'motivo' => null];
        }

        // 3. Por nombre. Si varios lo comparten, el correo desempata.
        $porNombre = $this->candidatosPorNombre($nombreRrhh);

        if ($porNombre->count() > 1 && $correoRrhh !== null) {
            $desempatados = $porNombre->filter(
                fn (User $user): bool => $this->mismoCorreo($user, $correoRrhh)
            )->values();

            if ($desempatados->count() === 1) {
                return ['user' => $desempatados->first(), 'motivo' => null];
            }
        }

        if ($porNombre->count() === 1) {
            return ['user' => $porNombre->first(), 'motivo' => null];
        }

        if ($porNombre->count() > 1) {
            return ['user' => null, 'motivo' => sprintf(
                'Hay %d colaboradores locales con ese nombre (ids %s) y el correo no los distingue: no se puede saber cuál es.',
                $porNombre->count(),
                $porNombre->pluck('id')->implode(', '),
            )];
        }

        // 4. Por correo, cuando el nombre está escrito de otra forma. Sólo si
        // el correo identifica a una persona en rrhh y a una sola aquí.
        $porCorreo = $this->candidatosPorCorreo($correoRrhh);

        if ($porCorreo->count() === 1) {
            return ['user' => $porCorreo->first(), 'motivo' => null];
        }

        // 5. El id está libre: se crea con el mismo id de rrhh.
        if ($porId === null) {
            return ['user' => null, 'motivo' => null];
        }

        return ['user' => null, 'motivo' => sprintf(
            'El id %d aquí es %s, otra persona. Hay que decidir con qué id vive este colaborador.',
            $rrhhId,
            $porId->name,
        )];
    }

    /**
     * Filas sin vincular que podrían ser esta persona.
     *
     * @return Collection<int, User>
     */
    protected function candidatosPorNombre(string $nombreRrhh): Collection
    {
        if ($nombreRrhh === '') {
            return collect();
        }

        return User::query()
            ->whereNull('rrhh_employee_id')
            ->get()
            ->filter(fn (User $user): bool => $this->esLaMismaPersona($this->nombreDe($user), $nombreRrhh))
            ->values();
    }

    /**
     * Filas sin vincular que traen ese correo.
     *
     * @return Collection<int, User>
     */
    protected function candidatosPorCorreo(?string $correoRrhh): Collection
    {
        if ($correoRrhh === null) {
            return collect();
        }

        return User::query()
            ->whereNull('rrhh_employee_id')
            ->get()
            ->filter(fn (User $user): bool => $this->mismoCorreo($user, $correoRrhh))
            ->values();
    }

    /**
     * ¿Esta fila local es la persona que rrhh está mandando? Con el nombre o
     * con el correo alcanza; si el payload no trae ninguno de los dos, no hay
     * con qué desmentir el id.
     */
    protected function confirmaIdentidad(User $user, string $nombreRrhh, ?string $correoRrhh): bool
    {
        if ($nombreRrhh === '' && $correoRrhh === null) {
            return true;
        }

        return $this->esLaMismaPersona($this->nombreDe($user), $nombreRrhh)
            || $this->mismoCorreo($user, $correoRrhh);
    }

    /**
     * Correo del payload sólo cuando sirve para identificar: rrhh avisa con
     * `email_compartido` cuáles son buzones compartidos o basura (`NA`,
     * vacío). Si el aviso no viene —una versión vieja de rrhh— se asume
     * compartido y el correo no se usa: es el lado seguro.
     *
     * @param  array<string, mixed>  $employee
     */
    protected function correoIdentificable(array $employee): ?string
    {
        if (($employee['email_compartido'] ?? true) === true) {
            return null;
        }

        $correo = mb_strtolower(trim((string) ($employee['email'] ?? '')));

        return filter_var($correo, FILTER_VALIDATE_EMAIL) !== false ? $correo : null;
    }

    protected function mismoCorreo(User $user, ?string $correoRrhh): bool
    {
        if ($correoRrhh === null) {
            return false;
        }

        return mb_strtolower(trim((string) $user->email)) === $correoRrhh;
    }

    /**
     * Dos nombres son de la misma persona si coinciden, o si todos los
     * apellidos y nombres de uno están en el otro. Eso cubre el caso normal:
     * rrhh guarda el nombre completo y aquí quedó el corto («Denise Reyes
     * Ramírez» y «Denise Marisol Reyes Ramírez» son la misma persona).
     */
    protected function esLaMismaPersona(string $a, string $b): bool
    {
        if ($a === '' || $b === '') {
            return false;
        }

        if ($a === $b) {
            return true;
        }

        $partesA = explode(' ', $a);
        $partesB = explode(' ', $b);

        $corto = count($partesA) <= count($partesB) ? $partesA : $partesB;
        $largo = count($partesA) <= count($partesB) ? $partesB : $partesA;

        // Con una sola palabra en común no alcanza: «María» no identifica a nadie.
        return count($corto) >= 2 && array_diff($corto, $largo) === [];
    }

    /**
     * Minúsculas, sin acentos, sin puntuación y con los espacios colapsados.
     * Los dos lados arrastran dobles espacios, tabuladores y acentos puestos
     * a mano.
     */
    protected function normalizar(?string $valor): string
    {
        $limpio = mb_strtolower(trim((string) $valor));

        $limpio = strtr($limpio, [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u',
            'ä' => 'a', 'ë' => 'e', 'ï' => 'i', 'ö' => 'o', 'ü' => 'u',
            'ñ' => 'n', 'ç' => 'c',
        ]);

        return trim(preg_replace('/\s+/', ' ', preg_replace('/[^a-z0-9 ]/', ' ', $limpio)));
    }

    /**
     * @param  array<string, mixed>  $employee
     */
    protected function nombreDelPayload(array $employee): string
    {
        return $employee['full_name']
            ?? trim(($employee['first_name'] ?? '').' '.($employee['last_name'] ?? ''));
    }

    /**
     * Nombre completo de un colaborador local, normalizado. Aquí el nombre
     * vive en una sola columna.
     */
    protected function nombreDe(User $user): string
    {
        return $this->normalizar($user->name);
    }

    /**
     * Traduce el payload de rrhh a las columnas de la tabla local `users`.
     * Aquí el nombre completo cae en `name` y el puesto en `puesto` (ambas
     * columnas NOT NULL). `management_id` no se toca: es propio de compras.
     *
     * `rrhh_employee_id` sella el vínculo: a partir de la primera corrida ya
     * no hay que adivinar quién es quién.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mapAttributes(array $data): array
    {
        return [
            'name' => $this->nombreDelPayload($data),
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'puesto' => $data['job']['name'] ?? '',
            'active' => (bool) ($data['active'] ?? true),
            'rrhh_employee_id' => $data['employee_id'] ?? null,
        ];
    }
}
