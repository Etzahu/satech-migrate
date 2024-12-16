<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\ReviewResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Purchases\Resources\PurchaseOrder\ReviewResource;

class ListPurchaseOrders extends ListRecords
{
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
