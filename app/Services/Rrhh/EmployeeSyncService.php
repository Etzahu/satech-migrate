<?php

namespace App\Services\Rrhh;

use App\Models\User;

class EmployeeSyncService
{
    /**
     * Enruta cada evento del webhook de rrhh hacia la acción que le
     * corresponde sobre la tabla local `users`.
     *
     * @param  array<string, mixed>  $data
     */
    public function handle(string $event, array $data): void
    {
        match ($event) {
            'employee.created', 'employee.updated' => $this->upsert($data),
            'employee.deleted' => $this->deactivate($data),
            default => null,
        };
    }

    /**
     * Inserta o actualiza un colaborador. La coincidencia primaria es por
     * `id` (el mismo identificador que se comparte entre plataformas) y,
     * como verificación secundaria, por `email` cuando el `id` aún no
     * existe localmente; así se evita duplicar a alguien ya registrado.
     *
     * @param  array<string, mixed>  $data
     */
    public function upsert(array $data): User
    {
        $user = $this->locate($data);

        if (! $user) {
            $user = new User;
            $user->id = $data['employee_id'];
        }

        $user->forceFill($this->mapAttributes($data))->save();

        return $user;
    }

    /**
     * Un colaborador eliminado en rrhh se desactiva localmente en lugar de
     * borrarse, para no romper las referencias de otros registros que
     * apuntan a su `id`.
     *
     * @param  array<string, mixed>  $data
     */
    public function deactivate(array $data): void
    {
        $this->locate($data)?->forceFill(['active' => false])->save();
    }

    /**
     * Busca el colaborador por `id` y, si no existe, por `email`.
     *
     * @param  array<string, mixed>  $data
     */
    protected function locate(array $data): ?User
    {
        $user = User::find($data['employee_id']);

        if (! $user && ! empty($data['email'])) {
            $user = User::where('email', $data['email'])->first();
        }

        return $user;
    }

    /**
     * Traduce el payload de rrhh a las columnas de la tabla local `users`.
     * Aquí el nombre completo cae en `name` y el puesto en `puesto` (ambas
     * columnas NOT NULL). `management_id` no se toca: es propio de compras.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mapAttributes(array $data): array
    {
        $name = $data['full_name']
            ?? trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? ''));

        return [
            'name' => $name,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'puesto' => $data['job']['name'] ?? '',
            'active' => (bool) ($data['active'] ?? true),
        ];
    }
}
