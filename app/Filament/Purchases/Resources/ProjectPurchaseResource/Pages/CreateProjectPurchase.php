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
        $data['registered_user_id'] = auth()->user()->id;
        $data['requester_id'] = auth()->user()->id;
        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->status()->transitionTo('pendiente');
        $this->record->status()->transitionTo('activo');
    }

}
