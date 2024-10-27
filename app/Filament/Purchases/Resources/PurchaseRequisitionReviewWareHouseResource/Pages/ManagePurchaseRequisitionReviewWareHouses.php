<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisitionReviewWareHouseResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisitionReviewWareHouseResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePurchaseRequisitionReviewWareHouses extends ManageRecords
{
    protected static string $resource = PurchaseRequisitionReviewWareHouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
