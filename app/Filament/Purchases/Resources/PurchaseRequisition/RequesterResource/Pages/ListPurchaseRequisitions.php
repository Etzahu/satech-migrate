<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource;

class ListPurchaseRequisitions extends ListRecords
{
    protected static string $resource = RequesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'drafts' => Tab::make('Borradores')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereIn('status', ['borrador', 'devuelto por almacén', 'devuelto por revisor', 'devuelto por gerencia', 'devuelto por DG', 'devuelto por comprador', 'devuelto por gerente de compras'])),
            'assigned' => Tab::make('Comprador asignado')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'comprador asignado')),
            'closed' => Tab::make('Cerradas')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'cerrada')),
        ];
    }
    public function getDefaultActiveTab(): string | int | null
    {
        return 'drafts';
    }
}
