<?php

namespace App\Filament\Purchases\Resources\ProductResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Purchases\Resources\ProductResource;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = Str::of($data['name'])->squish()->lower();
        $data['code'] = Str::of($data['name'])->squish()->upper()->replace(' ', '');
        $data['brand'] = Str::of($data['name'])->squish()->lower();
        $data['part_num'] = Str::of($data['name'])->squish()->upper();
        return $data;
    }
}
