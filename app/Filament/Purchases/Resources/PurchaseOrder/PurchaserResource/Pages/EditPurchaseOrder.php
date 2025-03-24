<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages;

use Filament\Actions;
use App\Models\PurchaseOrder;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\MaxWidth;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource;


class EditPurchaseOrder extends EditRecord
{
    protected static string $resource = PurchaserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Actions\ViewAction::make(),
                // Actions\DeleteAction::make(),
                Actions\Action::make('Agregar partidas de la requisición')
                    ->color('success')
                    ->url(fn(PurchaseOrder $record): string => PurchaserResource::getUrl('add-item', ['record' => $record->id]))
                // Array of actions
            ])
                ->label('Opciones')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('primary')
                ->dropdownWidth(MaxWidth::Large)
                ->button()
        ];
    }
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
        ];
    }
    protected function afterSave(): void
    {
        $this->dispatch('refreshRelationManagerItems');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $sum = 0;
        foreach ($data['condition_payment'] as $item) {
            $sum += (int)$item['value'];
        }
        if ($sum != 100) {
            Notification::make()
                ->title('Las condiciones de pago deben dar el 100%')
                ->danger()
                ->color('danger')
                ->persistent()
                ->send();
            $this->halt();
        }
        return $data;
    }
    protected function afterFill(): void
    {
        $sum = 0;
        $collection = $this->record->condition_payment;
        if (filled($collection)) {
            foreach ($collection as $item) {
                $sum += (int)$item['value'];
            }
        }
        $this->data['total'] = $sum;
    }
}
