<?php

namespace App\Filament\Resources\PurchaseRequisitionApprovalChainResource\Pages;

use App\Filament\Resources\PurchaseRequisitionApprovalChainResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseRequisitionApprovalChain extends EditRecord
{
    protected static string $resource = PurchaseRequisitionApprovalChainResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
