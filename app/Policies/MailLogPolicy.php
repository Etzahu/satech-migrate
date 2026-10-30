<?php

namespace App\Policies;

use App\Models\User;
use Tapp\FilamentMailLog\Models\MailLog;

/**
 * La bitácora de correos (tapp/filament-maillog) guarda el contenido completo
 * de cada correo enviado: solo la ve super_admin. Sin esta policy, Filament la
 * abre a cualquiera que entre al panel. Lo que no se define aquí (crear,
 * editar, borrar uno por uno) queda negado: solo se borra por antigüedad, con
 * el botón "Limpiar antiguos" (deleteAny) o la limpieza de cada domingo.
 */
class MailLogPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    public function view(User $user, MailLog $mailLog): bool
    {
        return $user->hasRole('super_admin');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasRole('super_admin');
    }
}
