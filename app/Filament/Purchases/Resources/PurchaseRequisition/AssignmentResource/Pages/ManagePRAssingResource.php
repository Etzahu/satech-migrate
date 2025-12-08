<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentResource\Pages;

use Filament\Actions;
use App\Models\PurchaseRequisition;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentResource;

class ManagePRAssingResource extends ManageRecords
{
    protected static string $resource = AssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'without' => Tab::make('Sin órdenes')
                ->badge(PurchaseRequisition::doesntHave('orders')
                    ->myAssing()
                    ->whereNot('status', 'cerrada')
                    ->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->doesntHave('orders')
                        ->myAssing()
                        ->whereNot('status', 'cerrada')
                ),
            'with' => Tab::make('Pendientes')
                ->modifyQueryUsing(fn(Builder $query) => $query
                    ->whereNot('status', 'cerrada')
                    ->has('orders')->orderBy('created_at', 'ASC')),
            'close' => Tab::make('Liberadas')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'cerrada')->orderBy('created_at', 'ASC')),
        ];
    }
}
