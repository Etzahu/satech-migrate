<?php

namespace App\Filament\Purchases\Resources\PRAssingResource\Pages;

use App\Filament\Purchases\Resources\PRAssingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePRApprovalDGS extends ManageRecords
{
    protected static string $resource = PRAssingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
