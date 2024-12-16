<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages;


use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource;

class ListPurchaseOrders extends ListRecords
{
    protected static string $resource = PurchaserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
