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
            'borrador' => ['revisión gerente de compras'],
            'revisión gerente de compras' =>  ['aprobado por gerente de compras', 'devuelto por gerente de compras', 'cancelado por gerente de compras'],

            'aprobado por gerente de compras' => ['aprobado por gerente solicitante', 'devuelto por gerente solicitante', 'cancelado por gerente solicitante'],
            'aprobado por gerente solicitante' => ['aprobado por DG nivel 1', 'devuelto por DG nivel 1', 'cancelado por DG nivel 1'],
            'aprobado por DG nivel 1' =>  ['revision por DG nivel 2', 'aprobada para emisión'],
            'revision por DG nivel 2' => ['aprobada para emisión', 'devuelto por DG nivel 2', 'cancelado por DG nivel 2'],


            'devuelto por gerente solicitante' => ['revisión gerente de compras'],
            'devuelto por DG nivel 1' => ['revisión gerente de compras'],
            'devuelto por DG nivel 2' => ['revisión gerente de compras'],
        ];
    }
    public function defaultState(): ?string
    {
        return 'borrador';
    }
}
