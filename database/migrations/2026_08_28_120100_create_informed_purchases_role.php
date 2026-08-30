<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Rol del nivel informativo de compras.
 *
 * Un solo rol para los dos documentos: el correo de Jorge pide el informativo
 * sobre las órdenes y el de Alan sobre las requisiciones de Manufactura, y
 * Operaciones confirmó el 28-ago-2026 que aplica a los dos para las cinco
 * gerencias. Quién ve qué lo decide `management_informed_rules`, no el rol: el
 * rol solo abre la pestaña.
 *
 * Retira además `visor_ordenes` y `visor_requisiciones` a Jennifer. Sin eso el
 * informativo sería decorativo en su caso: esos roles le abren la pestaña
 * *Todas*, con todas las órdenes y requisiciones de la empresa, y la regla por
 * categoría de Manufactura no filtraría nada.
 *
 * Va como migración y no como seeder porque los seeders no corren en
 * producción. Es idempotente: se puede volver a ejecutar sin duplicar nada.
 */
return new class extends Migration
{
    private const ROLE = 'informativo_compras';

    private const PERMISSIONS = [
        'view_informed_purchase::order::purchaser',
        'view_informed_purchase::requisition::requester',
    ];

    /**
     * Los cinco informativos de la tabla del correo.
     *
     * Allan Vázquez (MTTOESP) · Jennifer Jarquín (ING) · Jesús Becerra (ISW)
     * Eddie S. Ordoñez (MAN) · Iván Ponce (ST)
     */
    private const INFORMED_USER_IDS = [348, 191, 14, 333, 22];

    /** Jennifer Martínez Jarquín. */
    private const JENNIFER_USER_ID = 191;

    /** Roles que se le retiran a Jennifer al entrar al nivel informativo. */
    private const WIDE_VIEWER_ROLES = ['visor_ordenes', 'visor_requisiciones'];

    public function up(): void
    {
        $role = Role::firstOrCreate(['name' => self::ROLE, 'guard_name' => 'web']);

        foreach (self::PERMISSIONS as $name) {
            $permission = Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);

            $role->givePermissionTo($permission);

            // Los super_admin ven todos los paneles.
            foreach (['super_admin', 'super_admin_sg'] as $superAdmin) {
                Role::where('name', $superAdmin)->where('guard_name', 'web')->first()
                    ?->givePermissionTo($permission);
            }
        }

        foreach (self::INFORMED_USER_IDS as $id) {
            $user = User::find($id);

            if ($user && ! $user->hasRole(self::ROLE)) {
                $user->assignRole(self::ROLE);
            }
        }

        $jennifer = User::find(self::JENNIFER_USER_ID);

        if ($jennifer) {
            foreach (self::WIDE_VIEWER_ROLES as $name) {
                if ($jennifer->hasRole($name)) {
                    $jennifer->removeRole($name);
                }
            }
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        $jennifer = User::find(self::JENNIFER_USER_ID);

        if ($jennifer) {
            foreach (self::WIDE_VIEWER_ROLES as $name) {
                if (Role::where('name', $name)->where('guard_name', 'web')->exists()
                    && ! $jennifer->hasRole($name)) {
                    $jennifer->assignRole($name);
                }
            }
        }

        Role::where('name', self::ROLE)->where('guard_name', 'web')->first()?->delete();

        foreach (self::PERMISSIONS as $name) {
            Permission::where('name', $name)->where('guard_name', 'web')->first()?->delete();
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
