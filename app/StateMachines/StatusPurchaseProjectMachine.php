<?php

namespace App\StateMachines;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectPurchaseNotification;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class StatusPurchaseProjectMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return false;
    }

    public function transitions(): array
    {
        return [
            'borrador' => ['pendiente'],
            'pendiente' => ['activo', 'rechazado'],
            'rechazado' => ['pendiente'],
            'activo' => ['inactivo']
        ];
    }

    public function defaultState(): ?string
    {
        return 'borrador';
    }
    public function afterTransitionHooks(): array
    {
        return [
            'pendiente' => [
                function ($to, $model) {
                    $model->load('company', 'requester');
                    $usersPurchase = User::role('gerente_compras')->get();
                    $usersAdmin = User::role('administrador_compras')->get();

                    $recipients = [];
                    foreach ($usersPurchase as $user) {
                        $recipients[] = $user->email;
                    }
                    foreach ($usersAdmin as $user) {
                        $recipients[] = $user->email;
                    }
                    if ($model->requester_id !== $model->registered_user_id) {
                        Mail::to($recipients)->send(new ProjectPurchaseNotification($model));
                    }
                }
            ],
            'activo' => [
                function ($to, $model) {
                    if ($model->requester_id !== $model->registered_user_id) {
                        $model->load('company', 'requester');
                        $recipient = $model->requester->email;
                        Mail::to($recipient)->send(new ProjectPurchaseNotification($model));
                    }
                }
            ],
            'rechazado' => [
                function ($to, $model) {
                    $model->load('company', 'requester');
                    $recipient = $model->requester->email;
                    Mail::to($recipient)->send(new ProjectPurchaseNotification($model));
                }
            ],
        ];
    }
}
