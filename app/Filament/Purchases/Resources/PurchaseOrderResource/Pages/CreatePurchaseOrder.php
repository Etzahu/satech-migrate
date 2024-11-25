<?php

namespace App\Filament\Purchases\Resources\PurchaseOrderResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Purchases\Resources\PurchaseOrderResource;

class CreatePurchaseOrder extends CreateRecord
{
    protected static string $resource = PurchaseOrderResource::class;
    protected static bool $canCreateAnother = false;
}
