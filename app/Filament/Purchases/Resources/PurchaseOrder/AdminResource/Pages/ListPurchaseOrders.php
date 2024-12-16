<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\AdminResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Purchases\Resources\PurchaseOrder\AdminResource;

class ListPurchaseOrders extends ListRecords
{
    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
