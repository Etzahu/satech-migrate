<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Quien se da de baja pierde todos sus roles.
     *
     * Va en el observer porque las bajas llegan por más de un camino: el
     * interruptor "Activo" de la pantalla de usuarios y la sincronización con
     * RRHH (webhook y padrón). Solo actúa en el paso de activo a inactivo;
     * reactivar a alguien no le devuelve los roles.
     */
    public function updated(User $user): void
    {
        if ($user->wasChanged('active') && ! $user->active) {
            $user->revokeAllRoles();
        }
    }
}
