<?php

namespace App\Filament\Resources\PurchaseRequisitionApprovalChainResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PurchaseRequisitionApprovalChainResource;

class CreatePurchaseRequisitionApprovalChain extends CreateRecord
{
    protected static string $resource = PurchaseRequisitionApprovalChainResource::class;
    // protected function beforeCreate(): void
    // {
    //     if (true) {
    //         Notification::make()
    //             ->warning()
    //             ->title('You don\'t have an active subscription!')
    //             ->body('Choose a plan to continue.')
    //             ->persistent()
    //             ->actions([
    //                 Action::make('subscribe')
    //                     ->button()
    //                     ->url('https://filamentphp.com', shouldOpenInNewTab: true),
    //             ])
    //             ->send();

    //         $this->halt();
    //     }
    // }
}
