<?php

namespace App\Filament\Purchases\Resources\RequestIncorporation\PurchaseProviderResource\Pages;

use App\Filament\Purchases\Resources\RequestIncorporation\PurchaseProviderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseProvider extends CreateRecord
{
    protected static string $resource = PurchaseProviderResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['rfc'] = str($data['rfc'])->trim();
        $data['company_name'] = str($data['company_name'])->squish();
        $data['user_request_id'] = auth()->user()->id;
        return $data;
    }
    
}
