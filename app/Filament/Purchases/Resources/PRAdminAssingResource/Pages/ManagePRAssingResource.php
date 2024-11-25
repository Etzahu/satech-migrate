<?php

namespace App\Filament\Purchases\Resources\PRAdminAssingResource\Pages;

use App\Filament\Purchases\Resources\PRAdminAssingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePRAdminAssing extends ManageRecords
{
    protected static string $resource = PRAdminAssingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
