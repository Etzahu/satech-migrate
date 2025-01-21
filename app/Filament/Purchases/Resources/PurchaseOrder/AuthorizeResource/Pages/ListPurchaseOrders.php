<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\AuthorizeResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Purchases\Resources\PurchaseOrder\AuthorizeResource;

class ListPurchaseOrders extends ListRecords
{
    protected static string $resource = AuthorizeResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
