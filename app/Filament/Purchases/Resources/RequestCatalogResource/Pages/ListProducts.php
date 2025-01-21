<?php

namespace App\Filament\Purchases\Resources\RequestCatalogResource\Pages;

use App\Filament\Purchases\Resources\RequestCatalogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = RequestCatalogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Solicitar'),
        ];
    }
}
