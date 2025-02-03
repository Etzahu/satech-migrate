<?php

namespace App\Filament\Purchases\Resources\PurchaseProviderResource\Pages;

use Filament\Resources\Components\Tab;
use App\Filament\Purchases\Resources\PurchaseProviderResource;
use App\Models\PurchaseProvider;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPurchaseProviders extends ListRecords
{
    protected static string $resource = PurchaseProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            'Todo' => Tab::make('Todo'),
            'revisar' => Tab::make('Revisión')
                ->badge(PurchaseProvider::query()->where('status', 'revisión')->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'revisión')),
            'mis-proveedores' => Tab::make('Mis proveedores')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('user_request_id', auth()->user()->id)),
            'rechazados' => Tab::make('Rechazados')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'rechazado')),

        ];
    }
}
