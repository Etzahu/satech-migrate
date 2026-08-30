<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\ReleaseResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\ReleaseResource;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseOrders extends ListRecords
{
    protected static string $resource = ReleaseResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
