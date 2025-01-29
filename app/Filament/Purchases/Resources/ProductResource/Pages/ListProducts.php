<?php

namespace App\Filament\Purchases\Resources\ProductResource\Pages;

use App\Filament\Purchases\Resources\ProductResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Añadir'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'pendiente' => Tab::make('Pendientes')
                ->modifyQueryUsing(
                    fn(Builder $query) =>
                    $query->where('status', 'pendiente')
                        ->where('company_id', session()->get('company_id'))
                        ->orderBy('created_at', 'desc')
                )
                ->badge(
                    Product::query()->where('status', 'pendiente')
                        ->where('company_id', session()->get('company_id'))
                        ->count()
                )
                ->badgeColor('danger'),
            'aprobado' => Tab::make('Aprobados')
                ->modifyQueryUsing(fn(Builder $query) => $query
                ->where('status', 'aprobado')
                ->where('company_id', session()->get('company_id'))
                ->orderBy('created_at','desc')),
            'rechazado' => Tab::make('Rechazados')
                ->modifyQueryUsing(fn(Builder $query) => $query
                ->where('company_id', session()->get('company_id'))
                ->where('status', 'rechazado')),
            'admin' => Tab::make('Alta Admin')
                ->modifyQueryUsing(fn(Builder $query) => $query
                ->where('company_id', session()->get('company_id'))
                ->whereNull('status')),
        ];
    }
    public function getDefaultActiveTab(): string | int | null
    {
        return 'aprobado';
    }
}
