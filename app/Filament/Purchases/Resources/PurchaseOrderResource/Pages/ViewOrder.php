<?php

namespace App\Filament\Purchases\Resources\PurchaseOrderResource\Pages;

use Filament\Actions;
use App\Models\PurchaseOrder;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\MaxWidth;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Purchases\Resources\PurchaseOrderResource;

class ViewOrder extends ViewRecord
{
    protected static string $resource = PurchaseOrderResource::class;
    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Actions\EditAction::make(),
                Actions\Action::make('Agregar partidas de la requisición')
                ->color('success')
                ->url(fn(PurchaseOrder $record): string => PurchaseOrderResource::getUrl('add-item', ['record' => $record->id]))
            ])
                ->label('Opciones')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('primary')
                ->dropdownWidth(MaxWidth::Large)
                ->button()
        ];
    }
}
