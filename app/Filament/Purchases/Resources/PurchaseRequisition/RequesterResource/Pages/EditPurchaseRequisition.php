<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource;


class EditPurchaseRequisition extends EditRecord
{
    protected static string $resource = RequesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ViewAction::make()
        ];
    }
}
