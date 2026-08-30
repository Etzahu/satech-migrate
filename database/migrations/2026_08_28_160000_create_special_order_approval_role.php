<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Rol de la ruta especial de órdenes de compra (Fase E).
 *
 * Los 20 proveedores marcados `approval_chain = 'especial'` no recorren la
 * cadena: van de `borrador` a `revision por dirección general` y Dirección
 * Administrativa las autoriza directo. Ese nivel estaba cableado al **id 106**
 * en siete lugares del código, así que un cambio de persona en Dirección
 * Administrativa obligaba a tocar y desplegar código.
 *
 * Va aparte de `libera_orden_compra` a propósito: son autoridades distintas.
 * Liberar es un paso más del flujo normal; la ruta especial salta la cadena
 * entera y manda la orden al proveedor. Si mañana se nombra un suplente para
 * liberar, no debe heredar de paso la facultad de autorizar sin cadena.
 *
 * Va como migración y no como seeder porque los seeders no corren en
 * producción. Es idempotente.
 */
return new class extends Migration
{
    /** Denise Marisol Reyes Ramírez — Dirección Administrativa. */
    private const APPROVER_USER_ID = 106;

    private const ROLE = 'aprueba_orden_especial';

    private const PERMISSION = 'view_approve-special_purchase::order::purchaser';

    public function up(): void
    {
        $permission = Permission::firstOrCreate(['name' => self::PERMISSION, 'guard_name' => 'web']);

        $role = Role::firstOrCreate(['name' => self::ROLE, 'guard_name' => 'web']);
        $role->givePermissionTo($permission);

        foreach (['super_admin', 'super_admin_sg'] as $superAdmin) {
            Role::where('name', $superAdmin)->where('guard_name', 'web')->first()
                ?->givePermissionTo($permission);
        }

        $approver = User::find(self::APPROVER_USER_ID);

        if ($approver && ! $approver->hasRole(self::ROLE)) {
            $approver->assignRole(self::ROLE);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        Role::where('name', self::ROLE)->where('guard_name', 'web')->first()?->delete();
        Permission::where('name', self::PERMISSION)->where('guard_name', 'web')->first()?->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
