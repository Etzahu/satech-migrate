<?php

namespace App\Filament\Ingenieria\Resources\DrawingCategoryResource\Pages;

use App\Filament\Ingenieria\Resources\DrawingCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDrawingCategory extends EditRecord
{
    protected static string $resource = DrawingCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
