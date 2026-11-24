<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource;
use App\Models\PurchaseOrder;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPurchaseOrders extends ListRecords
{
    protected static string $resource = PurchaserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'draft' => Tab::make('Borradores')
                ->modifyQueryUsing(fn (Builder $query) => $query->notArchived()->whereIn('status', PurchaseOrder::PURCHASER_STATUSES)),
            'reopened' => Tab::make('Reabiertas')
                ->modifyQueryUsing(fn (Builder $query) => $query->notArchived()->where('status', 'reabierta para edición')),
            'released' => Tab::make('Liberadas')
                ->modifyQueryUsing(fn (Builder $query) => $query->notArchived()->where('status', 'autorizada para proveedor')),
            'archived' => Tab::make('Archivadas')
                ->modifyQueryUsing(fn (Builder $query) => $query->archived()),
        ];
    }
}
