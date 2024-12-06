<?php

namespace App\StateMachines;

use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class PurchaseOrderStateMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            //
        ];
    }

    public function defaultState(): ?string
    {
        return 'borrador';
    }
}
