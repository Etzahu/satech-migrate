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

            'devuelto por revisor' => ['revisión por almacén', 'revisión'],
            'devuelto por gerencia' => ['revisión por almacén', 'revisión'],
            'devuelto por DG' => ['revisión por almacén', 'revisión'],

            'revisión por almacén' => ['revisión'],
            'revisión' => ['aprobado por revisor', 'devuelto por revisor', 'cancelado por revisor'],
            'aprobado por revisor' => ['aprobado por gerencia', 'devuelto por gerencia', 'cancelado por gerencia'],
            'aprobado por gerencia' => ['aprobado por DG', 'devuelto por DG', 'cancelado por DG'],
        ];
    }
    public function defaultState(): ?string
    {
        return 'borrador';
    }
    public function afterTransitionHooks(): array
    {
        return [
            'revisión por almacén' => [
                function ($to, $model) {
                    $users = User::role('revisor_almacen_requisicion_compra')->get();
                    $service = new PurchaseRequisitionCreationService();
                    $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('para revisión por almacén', $model);
                    Mail::to($recipient)->send(new Notification($data));
                },
            ],
            'revisión' => [
                function ($to, $model) {
                     $users = $model->approvalChain->reviewer;
                     $service = new PurchaseRequisitionCreationService();
                     $recipient = $service->getUserForEmail($users?->toArray());
                     $data = $service->generateDataForEmail('para revisión', $model);
                     Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'aprobado por revisor' => [
                function ($to, $model) {
                    $users = $model->approvalChain->approver;
                    $service = new PurchaseRequisitionCreationService();
                    $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('para revisión por gerencia', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'devuelto por revisor' => [
                function ($to, $model) {
                    $users = $model->approvalChain->requester;
                    $service = new PurchaseRequisitionCreationService();
                    $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('devuelto por revisor', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'cancelado por revisor' => [
                function ($to, $model) {
                    $users = $model->approvalChain->requester;
                    $service = new PurchaseRequisitionCreationService();
                    $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('cancelado por revisor', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'aprobado por gerencia' => [
                function ($to, $model) {
                    $users = User::role('director_general_requisicion_compra')->get();
                    $service = new PurchaseRequisitionCreationService();
                    $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('para revisión por dirección general', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'devuelto por gerencia' => [
                function ($to, $model) {
                    $users = $model->approvalChain->requester;
                    $service = new PurchaseRequisitionCreationService();
                    $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('devuelto por gerencia', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'cancelado por gerencia' => [
                function ($to, $model) {
                     $users = $model->approvalChain->requester;
                    $service = new PurchaseRequisitionCreationService();
                    $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('cancelado por gerencia', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'aprobado por DG' => [
                function ($to, $model) {
                    $users = $model->approvalChain->requester;
                    $service = new PurchaseRequisitionCreationService();
                    $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('aprobado por dirección general', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'devuelto por DG' => [
                function ($to, $model) {
                    $users = $model->approvalChain->requester;
                    $service = new PurchaseRequisitionCreationService();
                    $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('devuelto por dirección general', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'cancelado por DG' => [
                function ($to, $model) {
                    $users = $model->approvalChain->requester;
                    $service = new PurchaseRequisitionCreationService();
                    $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('cancelado por dirección general', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],

        ];
    }
}
