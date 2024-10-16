<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CompanyResource;

class CreateCompany extends CreateRecord
{
    protected static string $resource = CompanyResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['acronym'] = Str::of($data['acronym'])->upper()->replace(' ', '');
        return $data;
    }
}
