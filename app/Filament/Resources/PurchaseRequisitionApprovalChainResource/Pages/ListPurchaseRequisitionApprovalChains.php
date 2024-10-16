<?php

namespace App\Filament\Resources\PurchaseRequisitionApprovalChainResource\Pages;

use App\Filament\Resources\PurchaseRequisitionApprovalChainResource;
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
