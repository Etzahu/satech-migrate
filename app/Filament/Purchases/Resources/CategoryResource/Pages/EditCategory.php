<?php

namespace App\Filament\Purchases\Resources\CategoryResource\Pages;

use App\Filament\Purchases\Resources\CategoryResource;
use Illuminate\Support\Str;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

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
        return $data;
    }
}
