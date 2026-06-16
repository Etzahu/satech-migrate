<?php

namespace App\Filament\Purchases\Resources\ProjectPurchaseResource\Pages;

use App\Filament\Purchases\Resources\ProjectPurchaseResource;
use App\Models\ProjectPurchase;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

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
            'pendiente' => Tab::make('Pendientes')
                ->modifyQueryUsing(
                    fn (Builder $query) => $query->where('status', 'pendiente')
                        ->where('company_id', session()->get('company_id'))
                        ->orderBy('created_at', 'desc')
                )
                ->badge(
                    ProjectPurchase::query()->where('status', 'pendiente')
                        ->where('company_id', session()->get('company_id'))
                        ->count()
                )
                ->badgeColor('danger'),
            'todos' => Tab::make('Todos')->modifyQueryUsing(
                fn (Builder $query) => $query->orderBy('created_at', 'desc')
            ),
            'rechazado' => Tab::make('Rechazados')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('company_id', session()->get('company_id'))
                    ->where('status', 'rechazado')),
        ];
    }
}
