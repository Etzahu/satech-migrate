<?php

namespace App\Filament\Purchases\Resources\ManagementResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Purchases\Resources\ManagementResource;

class EditManagement extends EditRecord
{
    protected static string $resource = ManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = Str::of($data['name'])->squish()->title();
        $data['acronym'] = Str::of($data['acronym'])->upper()->replace(' ', '');
        return $data;
    }
}
