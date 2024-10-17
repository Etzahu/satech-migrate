<?php

namespace App\Filament\Purchases\Resources\ProjectUsageResource\Pages;

use App\Filament\Purchases\Resources\ProjectUsageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProjectUsage extends CreateRecord
{
    protected static string $resource = ProjectUsageResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = str($data['name'])->squish()->lower();
        return $data;
    }
}
