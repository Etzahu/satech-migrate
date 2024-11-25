<?php

namespace App\StateMachines;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PurchaseRequisition\Notification;
use Filament\Notifications\Notification as NotificationFilament;
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
            'borrador' => ['revisión por almacén', 'revisión', 'aprobado por revisor'],

            'devuelto por revisor' => ['revisión por almacén', 'revisión'],
            'devuelto por gerencia' => ['revisión por almacén', 'revisión'],
            'devuelto por DG' => ['revisión por almacén', 'revisión'],
            'devuelto por almacén' => ['revisión por almacén'],

            'revisión por almacén' => ['revisión', 'devuelto por almacén'],
            'revisión' => ['aprobado por revisor', 'devuelto por revisor', 'cancelado por revisor'],
            'aprobado por revisor' => ['aprobado por gerencia', 'devuelto por gerencia', 'cancelado por gerencia'],
            'aprobado por gerencia' => ['aprobado por DG', 'devuelto por DG', 'cancelado por DG'],
            'aprobado por DG' => ['comprador asignado']
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
            'revisión por almacén' => [
                function ($to, $model) {
                    $users = User::role('revisor_almacen_requisicion_compra')->get();
                    $service = new PurchaseRequisitionCreationService();
                    $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('revisar existencia', $model);
                    Mail::to($recipient)->send(new Notification($data));
                    // NotificationFilament::make()
                    //     ->title('Revisar existencias de nueva requisicion')
                    //     ->sendToDatabase($users);
                },
            ],
            'revisión' => [
                function ($to, $model) {
                    // $users = $model->approvalChain->reviewer;
                    // $recipient = $service->getUserForEmail($users?->toArray());
                    $recipient = $model->approvalChain->reviewer;
                    $service = new PurchaseRequisitionCreationService();
                    $data = $service->generateDataForEmail('revisar', $model);
                    Mail::to($recipient)->send(new Notification($data));
                    if ($model->status()->latest()->from == 'revisar') {
                        $itemsHaveModifications = $service->compareRequestedAndPurchase($model->items);
                        if (count($itemsHaveModifications) > 0) {
                            $recipient = $model->approvalChain->requester;
                            $data = $service->generateDataForEmail('Almacén editó las partidas', $model);
                            $itemsForEmail = $service->getItemsForEmail($itemsHaveModifications);
                            $data['items'] = $itemsForEmail;
                            Mail::to($recipient)->send(new Notification($data));
                        }
                    }
                }
            ],
            'aprobado por revisor' => [
                function ($to, $model) {
                    $recipient = $model->approvalChain->approver;
                    $service = new PurchaseRequisitionCreationService();
                    // $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('revisar', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'devuelto por revisor' => [
                function ($to, $model) {
                    $recipient = $model->approvalChain->requester;
                    $service = new PurchaseRequisitionCreationService();
                    // $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('devuelto por revisor', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'cancelado por revisor' => [
                function ($to, $model) {
                    $recipient = $model->approvalChain->requester;
                    $service = new PurchaseRequisitionCreationService();
                    // $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('cancelado por revisor', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'aprobado por gerencia' => [
                function ($to, $model) {
                    $recipient = User::role('director_general_requisicion_compra')->get();
                    $service = new PurchaseRequisitionCreationService();
                    // $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('aprobar', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'devuelto por gerencia' => [
                function ($to, $model) {
                    $recipient = $model->approvalChain->requester;
                    $service = new PurchaseRequisitionCreationService();
                    // $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('devuelto por gerencia', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'cancelado por gerencia' => [
                function ($to, $model) {
                    $recipient = $model->approvalChain->requester;
                    $service = new PurchaseRequisitionCreationService();
                    // $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('cancelado por gerencia', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'aprobado por DG' => [
                function ($to, $model) {
                    $recipient = $model->approvalChain->requester;
                    $service = new PurchaseRequisitionCreationService();
                    // $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('aprobado por dirección general', $model);
                    $moreUsers = $service->getUserForEmailPRFinish($model);
                    Mail::to($recipient)->cc($moreUsers)->send(new Notification($data));
                }
            ],
            'devuelto por DG' => [
                function ($to, $model) {
                    $recipient = $model->approvalChain->requester;
                    $service = new PurchaseRequisitionCreationService();
                    // $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('devuelto por dirección general', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'cancelado por DG' => [
                function ($to, $model) {
                    $recipient = $model->approvalChain->requester;
                    $service = new PurchaseRequisitionCreationService();
                    // $recipient = $service->getUserForEmail($users?->toArray());
                    $data = $service->generateDataForEmail('cancelado por dirección general', $model);
                    Mail::to($recipient)->send(new Notification($data));
                }
            ],
            'comprador asignado' => [
                function ($to, $model) {
                    $model->load('responsiblePurchaseOrder');
                    $recipient = $model->responsiblePurchaseOrder->email;
                    $cc = $model->approvalChain->requester;
                    $service = new PurchaseRequisitionCreationService();
                    $data = $service->generateDataForEmail('colocar orden de compra', $model);
                    Mail::to($recipient)
                        ->cc($cc)
                        ->send(new Notification($data));
                }
            ],
        ];
    }
}
