<?php

namespace App\StateMachines;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationPurchaseProvider;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class StatusPurchaseProviderMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            'borrador' => ['revisión'],
            'revisión' => ['aprobado', 'rechazado'],
            'rechazado' => ['revisión']
        ];
    }

    public function defaultState(): ?string
    {
        return 'borrador';
    }
    public function afterTransitionHooks(): array
    {
        return [
            'revisión' => [
                function ($from, $model) {
                    $recipient = User::role('gerente_compras')->first()->email;
                    $data = [
                        'subject' => 'Nuevo proveedor para revisar',
                        'rfc' => $model->rfc,
                        'name' => $model->company_name,
                    ];
                    if($model->user_request_id !== $model->user_approve_id){
                        Mail::to($recipient)->send(new NotificationPurchaseProvider($data));
                    }
                },
            ],
            'aprobado' => [
                function ($from, $model) {
                    $recipient = $model->UserRequest->email;
                    $status = $model->status()->latest();
                    $data = [
                        'subject' => 'Proveedor aprobado',
                        'rfc' => $model->rfc,
                        'name' => $model->company_name,
                        'observations'=> filled($status) ? $status->getCustomProperty('respuesta') : ''
                    ];

                    if($model->user_request_id !== $model->user_approve_id){
                        Mail::to($recipient)->send(new NotificationPurchaseProvider($data));
                    }
                },
            ],
            'rechazado' => [
                function ($from, $model) {
                    $recipient = $model->UserRequest->email;
                    $data = [
                        'subject' => 'Proveedor rechazado',
                        'rfc' => $model->rfc,
                        'name' => $model->company_name,
                    ];
                    Mail::to($recipient)->send(new NotificationPurchaseProvider($data));
                },
            ],

        ];
    }
}
