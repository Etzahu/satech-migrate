<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\ChainResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\ChainResource;
use App\Models\PurchaseRequisitionApprovalChain;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPurchaseRequisitionApprovalChains extends ListRecords
{
    protected static string $resource = ChainResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'todas' => Tab::make('Todas')
                ->badge(PurchaseRequisitionApprovalChain::query()->count()),

            'en-uso' => Tab::make('En uso')
                ->icon('heroicon-m-link')
                ->modifyQueryUsing(fn (Builder $query) => $query->inUse())
                ->badge(PurchaseRequisitionApprovalChain::query()->inUse()->count())
                ->badgeColor('success'),

            'sin-uso' => Tab::make('Sin uso')
                ->icon('heroicon-m-link-slash')
                ->modifyQueryUsing(fn (Builder $query) => $query->unused())
                ->badge(PurchaseRequisitionApprovalChain::query()->unused()->count())
                ->badgeColor('gray'),

            'inactivas' => Tab::make('Con usuarios inactivos')
                ->icon('heroicon-m-exclamation-triangle')
                ->modifyQueryUsing(fn (Builder $query) => $query->withInactiveUsers())
                ->badge(PurchaseRequisitionApprovalChain::query()->withInactiveUsers()->count())
                ->badgeColor('danger'),
        ];
    }
}
