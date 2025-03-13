<?php

namespace App\Policies;

use App\Models\User;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Auth\Access\Response;

class AutidPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function audit(User $user): bool
    {
        dd($user);
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function restoreAudit(User $user, Audit $audit): bool
    {
        dd($user);
        return $user->hasRole('super_admin');
    }
}
