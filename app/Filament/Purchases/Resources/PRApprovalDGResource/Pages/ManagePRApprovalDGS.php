<?php

namespace App\Filament\Purchases\Resources\PRApprovalDGResource\Pages;

use App\Filament\Purchases\Resources\PRApprovalDGResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePRApprovalDGS extends ManageRecords
{
    protected static string $resource = PRApprovalDGResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
