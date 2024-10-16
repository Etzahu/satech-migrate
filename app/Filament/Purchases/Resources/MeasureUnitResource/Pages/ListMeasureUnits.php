<?php

namespace App\Filament\Purchases\Resources\MeasureUnitResource\Pages;

use App\Filament\Purchases\Resources\MeasureUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMeasureUnits extends ListRecords
{
    protected static string $resource = MeasureUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
