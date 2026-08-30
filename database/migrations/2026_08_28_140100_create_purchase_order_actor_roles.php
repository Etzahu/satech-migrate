<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Actores de la orden de compra en los cinco departamentos operativos (Fase D1).
 *
 * "Alan Alexis Anaya Arreola aprobará, Sergio Antonio Ordaz Espinoza autorizará
 * y Denise Reyes Ramírez liberará." — Jorge Ojeda, 19-ago-2026, confirmado por
 * Denise el mismo día.
 *
 * Se resuelven por rol y no por cadena porque la cadena tiene que seguir
 * sirviendo a la requisición, donde esos dos niveles los ocupan el gerente de
 * área y Alan. Dónde aplica el flujo lo marca `management.purchase_order_flow`.
 *
 * No introduce a nadie nuevo al sistema: Alan y Sergio ya operan estos niveles
 * en decenas de cadenas. Lo que cambia es que dejan de depender de estar
 * nombrados en cada una.
 *
 * Va como migración y no como seeder porque los seeders no corren en
 * producción. Es idempotente.
 */
return new class extends Migration
{
    /** Alan Alexis Anaya Arreola — aprueba la orden (nivel 2). */
    private const APPROVER_USER_ID = 341;

    /** Sergio Antonio Ordaz Espinoza — autoriza la orden (nivel 3). */
    private const AUTHORIZER_USER_ID = 168;

    private const ROLES = [
        'aprueba_orden_compra' => 'view_approve-chain_purchase::order::purchaser',
        'autoriza_orden_compra' => 'view_authorize-chain_purchase::order::purchaser',
    ];

    public function up(): void
    {
        foreach (self::ROLES as $roleName => $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);

            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->givePermissionTo($permission);

            foreach (['super_admin', 'super_admin_sg'] as $superAdmin) {
                Role::where('name', $superAdmin)->where('guard_name', 'web')->first()
                    ?->givePermissionTo($permission);
            }
        }

        $this->assign(self::APPROVER_USER_ID, 'aprueba_orden_compra');
        $this->assign(self::AUTHORIZER_USER_ID, 'autoriza_orden_compra');

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        foreach (self::ROLES as $roleName => $permissionName) {
            Role::where('name', $roleName)->where('guard_name', 'web')->first()?->delete();
            Permission::where('name', $permissionName)->where('guard_name', 'web')->first()?->delete();
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function assign(int $userId, string $role): void
    {
        $user = User::find($userId);

        if ($user && ! $user->hasRole($role)) {
            $user->assignRole($role);
        }
    }
};
