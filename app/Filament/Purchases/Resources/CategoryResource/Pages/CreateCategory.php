<?php

namespace App\Filament\Purchases\Resources\CategoryResource\Pages;
use Illuminate\Support\Str;
use App\Filament\Purchases\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = Str::of($data['name'])->squish()->lower();
        $data['code'] = Str::of($data['code'])->upper()->replace(' ', '');
        return $data;
    }
}
