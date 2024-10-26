<?php

namespace App\Filament\Purchases\Resources\ManagementResource\Pages;

use App\Filament\Purchases\Resources\ManagementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManagement extends ListRecords
{
    protected static string $resource = ManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
