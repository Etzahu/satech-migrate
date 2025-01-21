<?php

namespace App\StateMachines;

use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class CatalogStatusStateMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            'pendiente' => ['aprobado', 'rechazado'],
        ];
    }

    public function defaultState(): ?string
    {
        return 'pendiente';
    }

}
