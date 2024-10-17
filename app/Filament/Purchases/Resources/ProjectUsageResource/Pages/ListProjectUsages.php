<?php

namespace App\Filament\Purchases\Resources\ProjectUsageResource\Pages;

use App\Filament\Purchases\Resources\ProjectUsageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectUsages extends ListRecords
{
    protected static string $resource = ProjectUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
