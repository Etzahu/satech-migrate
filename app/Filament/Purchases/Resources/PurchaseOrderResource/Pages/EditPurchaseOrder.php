<?php

namespace App\Filament\Purchases\Resources\PurchaseOrderResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use App\Filament\Purchases\Resources\PurchaseOrderResource;

class EditPurchaseOrder extends EditRecord
{
    protected static string $resource = PurchaseOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
