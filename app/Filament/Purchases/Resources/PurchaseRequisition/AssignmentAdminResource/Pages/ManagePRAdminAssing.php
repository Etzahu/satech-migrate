<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentAdminResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePRAdminAssing extends ManageRecords
{
    protected static string $resource = AssignmentAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
