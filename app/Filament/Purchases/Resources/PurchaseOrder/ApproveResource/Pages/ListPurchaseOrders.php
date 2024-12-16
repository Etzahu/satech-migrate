<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\ApproveResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Purchases\Resources\PurchaseOrder\ApproveResource;

class ListPurchaseOrders extends ListRecords
{
    protected static string $resource = ApproveResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
