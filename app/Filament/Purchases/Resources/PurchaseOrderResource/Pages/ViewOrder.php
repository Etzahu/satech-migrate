<?php

namespace App\Filament\Purchases\Resources\PurchaseOrderResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrderResource;
use App\Models\PurchaseOrder;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = PurchaseOrderResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('Agregar partidas de la requisición')
            ->color('success')
            ->url(fn(PurchaseOrder $record): string => PurchaseOrderResource::getUrl('add-item', ['record' => $record->id]))
        ];
    }
}
