<?php

namespace App\Filament\Purchases\Resources\PurchaseOrderResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Purchases\Resources\PurchaseOrderResource;

class ListPurchaseOrders extends ListRecords
{
    protected static string $resource = PurchaseOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
