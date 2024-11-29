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
            'Todo' => Tab::make('Todo')
                ->badge(PurchaseProvider::count()),
            'mis-proveedores' => Tab::make('Mis proveedores')
                ->badge(PurchaseProvider::query()->where('user_request_id', auth()->user()->id)->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('user_request_id', auth()->user()->id)),
            'rechazados' => Tab::make('Rechazados')
                ->badge(PurchaseProvider::query()->where('status', 'rechazado')->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'rechazado')),
        ];
    }
}
