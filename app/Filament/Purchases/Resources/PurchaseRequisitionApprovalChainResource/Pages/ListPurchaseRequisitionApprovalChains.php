<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisitionApprovalChainResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisitionApprovalChainResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseRequisitionApprovalChains extends ListRecords
{
    protected static string $resource = PurchaseRequisitionApprovalChainResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
