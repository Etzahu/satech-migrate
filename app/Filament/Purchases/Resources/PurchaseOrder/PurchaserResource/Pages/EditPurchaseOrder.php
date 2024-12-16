<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages;

use Filament\Actions;
use App\Models\PurchaseOrder;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\MaxWidth;
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
}
