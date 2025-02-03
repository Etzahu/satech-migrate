<?php

namespace App\Filament\Purchases\Resources\RequestIncorporation\CatalogResource\Pages;

use App\Filament\Purchases\Resources\RequestIncorporation\CatalogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = CatalogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Solicitar'),
        ];
    }
}
