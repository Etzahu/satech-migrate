<?php

namespace App\Filament\Purchases\Resources\ProjectPurchaseResource\Pages;

use Filament\Actions;
use App\Models\ProjectPurchase;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Purchases\Resources\ProjectPurchaseResource;

class ListProjectPurchases extends ListRecords
{
    protected static string $resource = ProjectPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            'todos'=> Tab::make('Todos'),
            'pendiente' => Tab::make('Pendientes')
                ->modifyQueryUsing(
                    fn(Builder $query) =>
                    $query->where('status', 'pendiente')
                        ->where('company_id', session()->get('company_id'))
                        ->orderBy('created_at', 'desc')
                )
                ->badge(
                    ProjectPurchase::query()->where('status', 'pendiente')
                        ->where('company_id', session()->get('company_id'))
                        ->count()
                )
                ->badgeColor('danger'),
            'rechazado' => Tab::make('Rechazados')
                ->modifyQueryUsing(fn(Builder $query) => $query
                ->where('company_id', session()->get('company_id'))
                ->where('status', 'rechazado')),
        ];
    }
}
