<?php

namespace App\StateMachines;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PurchaseRequisition\Notification;
use Filament\Notifications\Notification as NotificationFilament;
use App\Services\PurchaseRequisitionCreationService;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class PROrderStateMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            
        ];
    }
    public function defaultState(): ?string
    {
        return '';
    }
    public function afterTransitionHooks(): array
    {
        // TODO: falta crear la logica en el caso donde los items de una partida si los tenga completo almacen
        return [

        ];
    }
}
