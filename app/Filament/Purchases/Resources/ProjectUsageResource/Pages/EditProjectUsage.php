<?php

namespace App\Filament\Purchases\Resources\ProjectUsageResource\Pages;

use App\Filament\Purchases\Resources\ProjectUsageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectUsage extends EditRecord
{
    protected static string $resource = ProjectUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = str($data['name'])->squish()->lower();
        return $data;
    }
}
