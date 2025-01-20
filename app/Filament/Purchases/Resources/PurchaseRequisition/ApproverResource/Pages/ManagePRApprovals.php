<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\ApproverResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\ApproverResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePRApprovals extends ManageRecords
{
    protected static string $resource = ApproverResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
