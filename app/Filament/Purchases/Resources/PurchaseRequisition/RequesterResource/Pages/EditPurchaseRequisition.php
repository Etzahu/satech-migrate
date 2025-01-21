<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages;

use Filament\Actions;
use Livewire\Attributes\On;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\ActionSize;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource;


#[On('refreshOwner')]
class EditPurchaseRequisition extends EditRecord
{
    protected static string $resource = RequesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('Enviar requisición')
                ->color('success')
                ->requiresConfirmation()
                ->visible(
                    $this->record->status()->canBe('revisión por almacén') && $this->record->items->count() > 0 ||
                        $this->record->status()->canBe('aprobado por revisor') && $this->record->items->count() > 0
                )
                ->action(function () {
                    if ($this->record->confidential) {
                        $this->record->status()->transitionTo('aprobado por revisor');
                    } else {
                        $this->record->status()->transitionTo('revisión por almacén');
                    }
                    Notification::make()
                        ->title('Requisición enviada')
                        ->success()
                        ->send();
                }),
                Actions\ViewAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->label('Opciones')
            ->icon('heroicon-m-ellipsis-vertical')
            ->size(ActionSize::Small)
            ->color('primary')
            ->button(),
        ];
    }
}
