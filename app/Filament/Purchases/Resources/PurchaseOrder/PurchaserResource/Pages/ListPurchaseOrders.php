<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource;
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
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('status', [
                    'borrador',
                    'devuelto por gerente de compras',
                    'devuelto por gerente solicitante',
                    'devuelto por DG nivel 1',
                    'devuelto por DG nivel 2',
                    'reabierta para edición',
                    'devuelto por administrador', // Permite agregar partidas cuando admin devuelve la orden
                ])),
            'reopened' => Tab::make('Reabiertas')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'reabierta para edición')),
            'released' => Tab::make('Liberadas')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'autorizada para proveedor')),
        ];
    }
}
