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
            'borrador' => ['revisión por almacén','revisión'],
            'revisión por almacén' => ['revisión'],
            'revisión' => ['aprobado por revisor', 'rechazado por revisor'],
            'aprobado por revisor' => ['aprobado por gerencia', 'rechazado por gerencia'],
            'aprobado por gerencia' => ['aprobado por DG', 'rechazado por DG'],
        ];
    }
    public function defaultState(): ?string
    {
        return 'borrador';
    }
}
