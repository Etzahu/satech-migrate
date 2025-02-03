<?php

namespace App\Filament\Purchases\Resources\RequestIncorporation\ProjectPurchaseResource\Pages;

use App\Filament\Purchases\Resources\RequestIncorporation\ProjectPurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectPurchases extends ListRecords
{
    protected static string $resource = ProjectPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
