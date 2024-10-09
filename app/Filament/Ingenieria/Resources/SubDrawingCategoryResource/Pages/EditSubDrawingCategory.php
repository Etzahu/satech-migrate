<?php

namespace App\Filament\Ingenieria\Resources\SubDrawingCategoryResource\Pages;

use App\Filament\Ingenieria\Resources\SubDrawingCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubDrawingCategory extends EditRecord
{
    protected static string $resource = SubDrawingCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
