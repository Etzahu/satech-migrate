<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerWareHouseResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerWareHouseResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePRReviewWareHouses extends ManageRecords
{
    protected static string $resource = ReviewerWareHouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
