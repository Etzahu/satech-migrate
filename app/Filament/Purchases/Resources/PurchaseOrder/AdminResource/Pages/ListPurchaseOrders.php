<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\AdminResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Purchases\Resources\PurchaseOrder\AdminResource;
use App\Models\PurchaseRequisition;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Components\Tab;

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
                    ->badge(PurchaseRequisition::query()->where('status', 'revisión gerente de compras')
                ->where('company_id', session()->get('company_id'))
                ->count())
                 ->badgeColor('danger'),
        ];
    }
}
