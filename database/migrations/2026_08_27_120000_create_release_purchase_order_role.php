<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Nivel de liberación de órdenes de compra (Dirección Administrativa).
 *
 * Solicitado por Operaciones el 18-ago-2026: toda orden de compra requiere
 * en todo momento la liberación de Denise Reyes, sin importar el departamento.
 * Por eso el nivel se resuelve por rol y no por cadena de aprobación — igual
 * que el nivel de monto de Allier, que ya funciona así.
 *
 * Va como migración y no como seeder porque los seeders no corren en producción.
 * Es idempotente: se puede volver a ejecutar sin duplicar nada.
 */
return new class extends Migration
{
    /** Denise Marisol Reyes Ramírez — titular del nivel de liberación. */
    private const RELEASER_USER_ID = 106;

    private const ROLE = 'libera_orden_compra';

    private const PERMISSION = 'view_release_purchase::order::purchaser';

    public function up(): void
    {
        $permission = Permission::firstOrCreate(
            ['name' => self::PERMISSION, 'guard_name' => 'web'],
        );

        $role = Role::firstOrCreate(
            ['name' => self::ROLE, 'guard_name' => 'web'],
        );

        $role->givePermissionTo($permission);

        // Los super_admin ven todos los paneles; el permiso se les asigna igual
        // que los otros cuatro niveles de la orden.
        foreach (['super_admin', 'super_admin_sg'] as $name) {
            Role::where('name', $name)->where('guard_name', 'web')->first()
                ?->givePermissionTo($permission);
        }

        $releaser = User::find(self::RELEASER_USER_ID);

        if ($releaser && ! $releaser->hasRole(self::ROLE)) {
            $releaser->assignRole(self::ROLE);
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
