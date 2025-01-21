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
            'aprobado por gerente solicitante' => ['autorizada para proveedor', 'aprobado por DG nivel 1', 'devuelto por DG nivel 1', 'cancelado por DG nivel 1'],
            'aprobado por DG nivel 1' =>  ['devuelto por DG nivel 2', 'cancelado por DG nivel 2', 'autorizada para proveedor'],


            'devuelto por gerente solicitante' => ['revisión gerente de compras'],
            'devuelto por DG nivel 1' => ['revisión gerente de compras'],
            'devuelto por DG nivel 2' => ['revisión gerente de compras'],
        ];
    }
    public function defaultState(): ?string
    {
        return 'borrador';
    }
    public function afterTransitionHooks(): array
    {
        // TODO: falta crear la logica en el caso donde los items de una partida si los tenga completo almacen
        return [
            'revisión gerente de compras' => [function ($to, $model) {}],
            'aprobado por gerente de compras' => [function ($to, $model) {}],
            'devuelto por gerente de compras' => [function ($to, $model) {}],
            'cancelado por gerente de compras' => [function ($to, $model) {}],
            'aprobado por gerente solicitante' => [function ($to, $model) {}],
            'devuelto por gerente solicitante' => [function ($to, $model) {}],
            'cancelado por gerente solicitante' => [function ($to, $model) {}],
            'autorizada para proveedor' => [function ($to, $model) {}],
            'aprobado por DG nivel 1' => [function ($to, $model) {}],
            'devuelto por DG nivel 1' => [function ($to, $model) {}],
            'cancelado por DG nivel 1' => [function ($to, $model) {}],
            'devuelto por DG nivel 2' => [function ($to, $model) {}],
            'cancelado por DG nivel 2' => [function ($to, $model) {}],
        ];
    }
}
