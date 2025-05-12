<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentAdminResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentAdminResource;
use App\Models\PurchaseRequisition;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;


class ManagePRAdminAssing extends ManageRecords
{
    protected static string $resource = AssignmentAdminResource::class;
    public function getTabs(): array
    {
        return [
            'unassigned' => Tab::make('Sin asignar')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'aprobado por DG')
                    ->where('company_id', session()->get('company_id')))
                ->badge(PurchaseRequisition::readyAssingCount())
                ->badgeColor('danger'),
            'with-assignment' => Tab::make('Asignadas')
                ->modifyQueryUsing(fn(Builder $query) =>
                $query
                    ->whereIn('status', ['comprador asignado', 'comprador reasignado', 'cerrada'])
                    ->where('company_id', session()->get('company_id'))),
            'all' => Tab::make('Todas')
                ->modifyQueryUsing(fn(Builder $query) => $query->readyAssing()),

        ];
    }
}
