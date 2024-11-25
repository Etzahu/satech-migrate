<?php

namespace App\Filament\Purchases\Resources\PRAssingResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Purchases\Resources\PRAssingResource;

class ManagePRAssingResource extends ManageRecords
{
    protected static string $resource = PRAssingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
