<?php

namespace App\StateMachines;

use App\Mail\CatalogNotification;
use Illuminate\Support\Facades\Mail;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class CatalogStatusStateMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            'pendiente' => ['aprobado', 'rechazado'],
        ];
    }

    public function defaultState(): ?string
    {
        return 'pendiente';
    }
    public function afterTransitionHooks(): array
    {
        return [
            'aprobado' => [
                function ($to, $model) {
                    $model->load('company', 'requester', 'unit');
                    $recipient = $model->requester->email;
                    Mail::to($recipient)->send(new CatalogNotification($model));
                }
            ],
            'rechazado' => [
                function ($to, $model) {
                    $model->load('company', 'requester', 'unit');
                    $recipient = $model->requester->email;
                    Mail::to($recipient)->send(new CatalogNotification($model));
                }
            ],
        ];
    }
}
