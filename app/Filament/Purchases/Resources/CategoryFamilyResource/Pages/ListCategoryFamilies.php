<?php

namespace App\Filament\Purchases\Resources\CategoryFamilyResource\Pages;

use App\Filament\Purchases\Resources\CategoryFamilyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryFamilies extends ListRecords
{
    protected static string $resource = CategoryFamilyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
