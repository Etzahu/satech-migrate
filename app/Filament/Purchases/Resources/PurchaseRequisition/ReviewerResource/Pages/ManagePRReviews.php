<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePRReviews extends ManageRecords
{
    protected static string $resource = ReviewerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
