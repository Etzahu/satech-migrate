<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\ChainResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\ChainResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseRequisitionApprovalChain extends EditRecord
{
    protected static string $resource = ChainResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
