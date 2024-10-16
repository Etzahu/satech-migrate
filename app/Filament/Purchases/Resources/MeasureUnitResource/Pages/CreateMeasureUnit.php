<?php

namespace App\Filament\Purchases\Resources\MeasureUnitResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Purchases\Resources\MeasureUnitResource;

class CreateMeasureUnit extends CreateRecord
{
    protected static string $resource = MeasureUnitResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = Str::of($data['name'])->squish()->lower();
        $data['acronym'] = Str::of($data['acronym'])->squish();
        return $data;
    }
}
