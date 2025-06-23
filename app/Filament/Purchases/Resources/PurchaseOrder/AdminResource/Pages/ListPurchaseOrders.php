<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\AdminResource\Pages;

use Filament\Actions;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Purchases\Resources\PurchaseOrder\AdminResource;

class ListPurchaseOrders extends ListRecords
{
    protected static string $resource = AdminResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Todas'),
            'review' => Tab::make('Revisar')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'revisión gerente de compras')
                    ->where('company_id', session()->get('company_id')))
                ->badge(PurchaseOrder::query()->where('status', 'revisión gerente de compras')
                    ->where('company_id', session()->get('company_id'))
                    ->count())
                ->badgeColor('danger'),
        ];
    }
}
