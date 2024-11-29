<?php

namespace App\Filament\Purchases\Resources\PurchaseProviderResource\Pages;

use App\Filament\Purchases\Resources\PurchaseProviderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseProvider extends EditRecord
{
    protected static string $resource = PurchaseProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ViewAction::make(),
        ];
    }
    protected function mutateFormSaveBeforeCreate(array $data): array
    {
        $data['rfc'] = str($data['rfc'])->trim();
        $data['company_name'] = str($data['company_name'])->squish();
        return $data;
    }
    // public function hasCombinedRelationManagerTabsWithContent(): bool
    // {
    //     return true;
    // }
}
