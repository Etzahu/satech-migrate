<?php

namespace App\StateMachines;

use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class PurchaseRequisitionStateMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            'borrador' => [
                'en revisión','aprobado','rechazado'
            ]
        ];
    }

    public function defaultState(): ?string
    {
        return 'borrador';
    }
}
