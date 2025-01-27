<?php

namespace App\StateMachines;

use App\Models\User;
use App\Services\OrderService;
use Illuminate\Support\Facades\Mail;
use App\Mail\PurchaseOrder\Notification;
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

            'devuelto por gerente de compras' => ['revisión gerente de compras'],
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
            'revisión gerente de compras' => [function ($to, $model) {
                $service = new OrderService();
                $data = $service->generateDataEmail($model->id, 'revisar');

                $recipients = User::role('gerente_compras')->get();
                $recipients = $service->getRecipientsArray($recipients);
                Mail::to($recipients)->send(new Notification($data));
            }],

            'aprobado por gerente de compras' => [function ($to, $model) {
                $service = new OrderService();
                $data = $service->generateDataEmail($model->id, 'revisar');

                $recipient = $model->requisition->approvalChain->approver->email;

                Mail::to($recipient)->send(new Notification($data));
            }],

            'devuelto por gerente de compras' => [function ($to, $model) {
                $service = new OrderService();
                $data = $service->generateDataEmail($model->id, 'devuelto por gerente de compras');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'cancelado por gerente de compras' => [function ($to, $model) {
                $service = new OrderService();
                $data = $service->generateDataEmail($model->id, 'cancelado por gerente de compras');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'aprobado por gerente solicitante' => [function ($to, $model) {
                $service = new OrderService();
                $data = $service->generateDataEmail($model->id, 'revision');

                $recipient = $model->requisition->approvalChain->authorizer->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'devuelto por gerente solicitante' => [function ($to, $model) {
                $service = new OrderService();
                $data = $service->generateDataEmail($model->id, 'devuelto por gerente solicitante');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'cancelado por gerente solicitante' => [function ($to, $model) {
                $service = new OrderService();
                $data = $service->generateDataEmail($model->id, 'cancelado por gerente solicitantee');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'autorizada para proveedor' => [function ($to, $model) {
                $service = new OrderService();
                $data = $service->generateDataEmail($model->id, 'autorizada para proveedor');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'aprobado por DG nivel 1' => [function ($to, $model) {
                $service = new OrderService();
                $data = $service->generateDataEmail($model->id, 'revisar');

                $recipients = User::role('autoriza_nivel-2-orden_compra')->get();
                $recipients = $service->getRecipientsArray($recipients);
                Mail::to($recipients)->send(new Notification($data));
            }],
            'devuelto por DG nivel 1' => [function ($to, $model) {
                $service = new OrderService();
                $data = $service->generateDataEmail($model->id, 'devuelto por DG');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'cancelado por DG nivel 1' => [function ($to, $model) {
                $service = new OrderService();
                $data = $service->generateDataEmail($model->id, 'cancelado por DG');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'devuelto por DG nivel 2' => [function ($to, $model) {
                $service = new OrderService();
                $data = $service->generateDataEmail($model->id, 'devuelto por DG');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'cancelado por DG nivel 2' => [function ($to, $model) {
                $service = new OrderService();
                $data = $service->generateDataEmail($model->id, 'cancelado por DG');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
        ];
    }
}
