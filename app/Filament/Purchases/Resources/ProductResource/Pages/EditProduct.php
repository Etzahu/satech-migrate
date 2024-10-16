<?php

namespace App\Filament\Purchases\Resources\ProductResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Purchases\Resources\ProductResource;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = Str::of($data['name'])->squish()->lower();
        $data['code'] = Str::of($data['name'])->upper()->replace(' ', '');
        $data['brand'] = Str::of($data['name'])->squish()->lower();
        $data['part_num'] = Str::of($data['name'])->upper()->replace(' ', '');
        return $data;
    }
}
