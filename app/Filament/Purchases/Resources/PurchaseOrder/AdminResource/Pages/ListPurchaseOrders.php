<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\AdminResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\AdminResource;
use App\Models\PurchaseOrder;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPurchaseOrders extends ListRecords
{
    protected static string $resource = AdminResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Todas'),
            'review' => Tab::make('Revisar')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'revisión gerente de compras')
                    ->where('company_id', session()->get('company_id')))
                ->badge(PurchaseOrder::query()->where('status', 'revisión gerente de compras')
                    ->where('company_id', session()->get('company_id'))
                    ->count())
                ->badgeColor('danger'),
            'deleted' => Tab::make('Borradas')
                ->modifyQueryUsing(fn (Builder $query) => $query->onlyTrashed())
                ->badge(PurchaseOrder::onlyTrashed()
                    ->where('company_id', session()->get('company_id'))
                    ->count())
                ->badgeColor('gray'),
        ];
    }
}
