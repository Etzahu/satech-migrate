<?php

namespace App\Filament\Purchases\Resources\PRApprovalResource\Pages;

use App\Filament\Purchases\Resources\PRApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePRApprovals extends ManageRecords
{
    protected static string $resource = PRApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
