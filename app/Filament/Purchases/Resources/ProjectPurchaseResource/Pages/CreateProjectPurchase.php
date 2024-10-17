<?php

namespace App\Filament\Purchases\Resources\ProjectPurchaseResource\Pages;

use App\Filament\Purchases\Resources\ProjectPurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProjectPurchase extends CreateRecord
{
    protected static string $resource = ProjectPurchaseResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = session()->get('company_id');
        $data['name'] = str($data['name'])->squish()->upper();
        return $data;
    }
}
