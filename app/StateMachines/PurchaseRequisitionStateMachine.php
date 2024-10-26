<?php

namespace App\StateMachines;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PurchaseRequisition\Notification;
use App\Services\PurchaseRequisitionCreationService;
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
            'borrador' => ['revisión por almacén', 'revisión'],
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
    public function beforeTransitionHooks(): array
    {
        return [
            'revisión por almacén' => [
                function ($to, $model) {
                    // buscar el usuario de almacen
                    $user = User::role('revisor_almacen_requisicion_compra')->first();
                    // Enviar notificacion
                    $service = new PurchaseRequisitionCreationService();
                    $data = $service->generateDataForEmail('para revisión por almacén', $model, $user);
                    Mail::to($data['user']['email'])->send(new Notification($data));
                },
            ],
        ];
    }
}
