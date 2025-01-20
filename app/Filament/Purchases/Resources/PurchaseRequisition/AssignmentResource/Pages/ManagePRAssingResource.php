<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentResource;

class ManageAssignmentResource extends ManageRecords
{
    protected static string $resource = AssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
