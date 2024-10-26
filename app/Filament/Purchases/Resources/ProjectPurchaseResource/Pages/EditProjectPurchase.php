<?php

namespace App\Filament\Purchases\Resources\ProjectPurchaseResource\Pages;

use App\Filament\Purchases\Resources\ProjectPurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectPurchase extends EditRecord
{
    protected static string $resource = ProjectPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function afterSave(): void
    {
         $this->dispatch('refresh');
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['code'] = str($data['code'])->squish()->upper();
        $data['name'] = str($data['name'])->squish()->upper();
        return $data;
    }
}
