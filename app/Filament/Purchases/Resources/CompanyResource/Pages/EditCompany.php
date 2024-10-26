<?php

namespace App\Filament\Purchases\Resources\CompanyResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Purchases\Resources\CompanyResource;

class EditCompany extends EditRecord
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['acronym'] = Str::of($data['acronym'])->upper()->replace(' ', '');
        return $data;
    }
}
