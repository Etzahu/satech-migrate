<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\PermissionRegistrar;

/**
 * Retira los roles a los usuarios que ya estaban dados de baja.
 *
 * Desde el 18-nov-2026 UserObserver le quita todos los roles a quien pasa a
 * inactivo, pero eso solo actúa en las bajas nuevas: los que ya estaban
 * inactivos —22 en la copia local del 11-nov, entre ellos Sergio Ordaz con
 * roles de aprobación y autorización— los conservaban y seguían apareciendo en
 * las listas que buscan a alguien por rol.
 *
 * Cada usuario queda en el log con los roles que tenía (revokeAllRoles), por si
 * hay que devolvérselos. Por eso down() no hace nada: reponerlos a ciegas
 * volvería a dejar inactivos con permisos.
 *
 * Va como migración y no como seeder porque los seeders no corren en
 * producción. Es idempotente: solo toca inactivos que todavía tienen roles.
 */
return new class extends Migration
{
    public function up(): void
    {
        // get() y no each(): each() pagina por offset y, como cada vuelta saca
        // al usuario del filtro, se saltaría registros.
        $inactiveUsersWithRoles = User::query()
            ->where('active', 0)
            ->whereHas('roles')
            ->orderBy('id')
            ->get();

        foreach ($inactiveUsersWithRoles as $user) {
            $user->revokeAllRoles();
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        //
    }
};
