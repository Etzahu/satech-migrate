<?php

namespace App\StateMachines;

use App\Mail\PurchaseOrder\Notification;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use App\Services\OrderService;
use App\Services\ProviderEvaluationService;
use App\Services\PurchaseInformedService;
use App\Services\PurchaseOrderChainResolver;
use App\Services\PurchaseOrderFlowService;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;
use Illuminate\Support\Facades\Mail;

class PurchaseOrderStateMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            // Wildcard: permite reasignar desde cualquier estado
            '*' => ['requisición reasignada', 'cadena reasignada', 'devuelto por administrador'],

            'borrador' => [
                'revisión gerente de compras',
                'revision por dirección general', // Existe un segundo camino cuando el proveedor en la orden es de una lista especial prorpocinada por el generente de compras
            ],
            'revisión gerente de compras' => ['aprobado por gerente de compras', 'devuelto por gerente de compras', 'cancelado por gerente de compras'],

            'aprobado por gerente de compras' => ['aprobado por gerente solicitante', 'devuelto por gerente solicitante', 'cancelado por gerente solicitante'],
            'aprobado por gerente solicitante' => ['aprobado por DG nivel 1', 'devuelto por DG nivel 1', 'cancelado por DG nivel 1'],
            // La liberación de Dirección Administrativa es obligatoria en todo
            // momento (Operaciones, 18-ago-2026), así que DG nivel 1 ya no puede
            // saltar directo al proveedor: siempre pasa por aquí.
            'aprobado por DG nivel 1' => ['liberado por dirección administrativa', 'devuelto por liberación', 'cancelado por liberación'],
            // El nivel de monto quedó al final del flujo: es la última aprobación.
            'liberado por dirección administrativa' => ['aprobado por DG nivel 2', 'autorizada para proveedor', 'devuelto por DG nivel 2', 'cancelado por DG nivel 2'],
            'aprobado por DG nivel 2' => ['autorizada para proveedor'],
            'autorizada para proveedor' => ['reabierta para edición'],

            'devuelto por gerente de compras' => ['revisión gerente de compras', 'revision por dirección general'],
            'devuelto por gerente solicitante' => ['revisión gerente de compras', 'revision por dirección general'],
            'devuelto por DG nivel 1' => ['revisión gerente de compras', 'revision por dirección general'],
            'devuelto por DG nivel 2' => ['revisión gerente de compras', 'revision por dirección general'],
            'devuelto por liberación' => ['revisión gerente de compras', 'revision por dirección general'],
            'devuelto por administrador' => ['revisión gerente de compras', 'revision por dirección general'],
            'reabierta para edición' => ['revisión gerente de compras', 'revision por dirección general'],

            // Estado de reasignación de requisición
            'requisición reasignada' => ['revisión gerente de compras', 'revision por dirección general'],

            // Estado de cambio de cadena de aprobación (sin cambiar requisición)
            'cadena reasignada' => ['revisión gerente de compras', 'revision por dirección general'],

            // Existe un segundo camino cuando el proveedor en la orden es de una lista especial prorpocinada por el generente de compras
            'revision por dirección general' => ['autorizada para proveedor', 'devuelto por dirección general', 'cancelado por dirección general'],
            'devuelto por dirección general' => ['revision por dirección general'],

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
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'revisar');

                $recipients = User::withRole('gerente_compras')->get();
                $recipients = $service->getRecipientsArray($recipients);
                Mail::to($recipients)->send(new Notification($data));
            }],

            // A quién le toca el nivel 2 lo decide el resolver: en los cinco
            // departamentos operativos es el rol, en el resto la cadena.
            'aprobado por gerente de compras' => [function ($to, $model) {
                $recipients = app(PurchaseOrderChainResolver::class)->approverEmails($model);

                if ($recipients === []) {
                    return;
                }

                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'revisar');

                Mail::to($recipients)->send(new Notification($data));
            }],

            'devuelto por gerente de compras' => [function ($to, $model) {
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'devuelto por gerente de compras');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'cancelado por gerente de compras' => [function ($to, $model) {
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'cancelado por gerente de compras');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'aprobado por gerente solicitante' => [function ($to, $model) {
                $recipients = app(PurchaseOrderChainResolver::class)->authorizerEmails($model);

                if ($recipients === []) {
                    return;
                }

                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'revision');

                Mail::to($recipients)->send(new Notification($data));
            }],
            'devuelto por gerente solicitante' => [function ($to, $model) {
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'devuelto por gerente solicitante');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'cancelado por gerente solicitante' => [function ($to, $model) {
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'cancelado por gerente solicitantee');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'autorizada para proveedor' => [function ($to, $model) {
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'autorizada para proveedor');
                $recipient = $model->purchaser->email;

                $moreUsers = $service->getUserForEmailFinish($model);
                Mail::to($recipient)->cc($moreUsers)->send(new Notification($data));

                // Desactivar evaluaciones pendientes para la orden, en caso de que existan, al autorizar la orden para el proveedor
                // ProviderEvaluationService::createForOrder($model);

                // Calcular la fecha de entrega a partir de los días capturados y la fecha de aprobación
                $model->final_delivery_date = now()->addDays((int) $model->delivery_days);
                $model->saveQuietly();
            }],
            // Antes este aviso iba al nivel de monto. Ahora el siguiente paso es
            // siempre la liberación, así que el correo va a quien libera; el
            // aviso por monto se movió a `liberado por dirección administrativa`.
            'aprobado por DG nivel 1' => [function ($to, $model) {
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'revisar');

                $recipients = $service->getRecipientsArray(User::withRole('libera_orden_compra')->get());

                if ($recipients === []) {
                    return;
                }

                Mail::to($recipients)->send(new Notification($data));
            }],
            // Última aprobación: solo las órdenes que superan el límite siguen a
            // Dirección General. Las demás las cierra advanceAfterRelease().
            'liberado por dirección administrativa' => [function ($to, $model) {
                // El correo pide "la notificación de la liberación", así que el
                // aviso al nivel informativo va aquí y no en el cierre: arriba
                // del límite el cierre todavía espera a Dirección General y
                // puede tardar días más.
                $informed = app(PurchaseInformedService::class)->emailsFor($model->requisition);

                if ($informed !== []) {
                    $service = new OrderService;
                    $data = $service->generateDataEmail($model->id, 'liberada');

                    Mail::to($informed)->send(new Notification($data));
                }

                if (! (new PurchaseOrderFlowService)->requiresAmountApproval($model)) {
                    return;
                }

                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'revisar');

                $recipients = $service->getRecipientsArray(User::withRole('autoriza_nivel-2-orden_compra')->get());

                if ($recipients === []) {
                    return;
                }

                Mail::to($recipients)->send(new Notification($data));
            }],
            'devuelto por liberación' => [function ($to, $model) {
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'devuelto por dirección administrativa');

                Mail::to($model->purchaser->email)->send(new Notification($data));
            }],
            'cancelado por liberación' => [function ($to, $model) {
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'cancelado por dirección administrativa');

                Mail::to($model->purchaser->email)->send(new Notification($data));
            }],
            'devuelto por DG nivel 1' => [function ($to, $model) {
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'devuelto por DG');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'cancelado por DG nivel 1' => [function ($to, $model) {
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'cancelado por DG');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'devuelto por DG nivel 2' => [function ($to, $model) {
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'devuelto por DG');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'cancelado por DG nivel 2' => [function ($to, $model) {
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'cancelado por DG');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],

            'revision por dirección general' => [function ($to, $model) {
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'revision');
                $recipient = User::withRole('aprueba_orden_especial')->pluck('email')->all();

                if ($recipient === []) {
                    return;
                }

                Mail::to($recipient)->send(new Notification($data));
            }],

            'devuelto por dirección general' => [function ($to, $model) {
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'devuelto por dirección general');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'cancelado por dirección general' => [function ($to, $model) {
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'cancelado por dirección general');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],

            'requisición reasignada' => [function ($to, $model) {
                // Obtener información de la reasignación del historial
                $historial = $model->status()->history()
                    ->where('to', 'requisición reasignada')
                    ->orderBy('created_at', 'desc')
                    ->first();

                $oldRequisitionId = $historial->custom_properties['old_requisition_id'] ?? null;
                $newRequisitionId = $historial->custom_properties['new_requisition_id'] ?? null;

                // Enviar notificación al comprador
                $service = new OrderService;

                // Generar datos para el correo de reasignación
                $data = [
                    'subject' => '🔄 Orden de Compra - Requisición Reasignada',
                    'title' => 'Requisición Reasignada',
                    'message' => "La orden de compra {$model->folio} ha sido reasignada a una nueva requisición debido a cambios en la cadena de aprobación.",
                    'folio' => $model->folio,
                    'order_id' => $model->id,
                    'status' => 'Requisición Reasignada',
                    'old_requisition' => $oldRequisitionId ? PurchaseRequisition::find($oldRequisitionId)?->folio : 'N/A',
                    'new_requisition' => $newRequisitionId ? PurchaseRequisition::find($newRequisitionId)?->folio : 'N/A',
                    'new_approver' => $model->requisition->approvalChain->approver->name ?? 'N/A',
                    'new_authorizer' => $model->requisition->approvalChain->authorizer->name ?? 'N/A',
                    'action_url' => 'https://app.gptsatech.com/compras',
                    'action_text' => 'Ver Orden de Compra',
                ];

                $recipient = $model->purchaser->email;

                // Enviar a comprador y al gerente de compras
                $purchaseManagers = User::withRole('gerente_compras')->pluck('email')->toArray();

                Mail::to($recipient)->cc($purchaseManagers)->send(new Notification($data));
            }],

            'cadena reasignada' => [function ($to, $model) {
                // Obtener información del cambio de cadena del historial
                $historial = $model->status()->history()
                    ->where('to', 'cadena reasignada')
                    ->orderBy('created_at', 'desc')
                    ->first();

                $oldChainId = $historial->custom_properties['old_chain_id'] ?? null;
                $newChainId = $historial->custom_properties['new_chain_id'] ?? null;

                $oldChain = $oldChainId ? PurchaseRequisitionApprovalChain::find($oldChainId) : null;
                $newChain = $newChainId ? PurchaseRequisitionApprovalChain::find($newChainId) : $model->requisition->approvalChain;

                // Usar OrderService para generar datos completos del email
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'cadena reasignada');

                // Agregar información adicional específica del cambio de cadena
                $data['subject'] = '🔄 Orden de Compra - Cadena de Aprobación Modificada';
                $data['title'] = 'Cadena de Aprobación Reasignada';
                $data['message'] = "La orden de compra {$model->folio} ha cambiado su cadena de aprobación y volverá al inicio del proceso.";
                $data['old_approver'] = $oldChain?->approver->name ?? 'N/A';
                $data['old_authorizer'] = $oldChain?->authorizer->name ?? 'N/A';
                $data['new_approver'] = $newChain?->approver->name ?? 'N/A';
                $data['new_authorizer'] = $newChain?->authorizer->name ?? 'N/A';

                $recipient = $model->purchaser->email;

                // Enviar a comprador, al gerente de compras y a los nuevos aprobadores
                $purchaseManagers = User::withRole('gerente_compras')->pluck('email')->toArray();
                $ccEmails = array_merge($purchaseManagers, [
                    $newChain?->approver->email,
                    $newChain?->authorizer->email,
                ]);

                Mail::to($recipient)->cc(array_filter($ccEmails))->send(new Notification($data));
            }],

            'devuelto por administrador' => [function ($to, $model) {
                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'devuelto por administrador');

                $recipient = $model->purchaser->email;

                Mail::to($recipient)->send(new Notification($data));
            }],
            'reabierta para edición' => [function ($to, $model) {
                ProviderEvaluationService::cancelPendingForOrder($model);

                $service = new OrderService;
                $data = $service->generateDataEmail($model->id, 'reabierta para edición');
                $recipient = $model->purchaser->email;
                $moreUsers = array_merge([
                    $model->requisition->approvalChain?->requester?->email,
                    $model->requisition->approvalChain?->authorizer?->email,
                ],
                    User::withRole('libera_orden_compra')->pluck('email')->all(),
                    User::withRole('gerente_compras')->pluck('email')->all(),
                );

                Mail::to($recipient)
                    ->cc(array_values(array_unique(array_filter($moreUsers))))
                    ->send(new Notification($data));
            }],
        ];
    }
}
