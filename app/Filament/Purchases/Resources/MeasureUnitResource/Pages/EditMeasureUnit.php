<?php

namespace App\Filament\Purchases\Resources\MeasureUnitResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Purchases\Resources\MeasureUnitResource;

class EditMeasureUnit extends EditRecord
{
    protected static string $resource = MeasureUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = Str::of($data['name'])->squish()->lower();
        return $data;
    }
}
