<?php

namespace App\Filament\Purchases\Resources\RequestIncorporation\ProjectPurchaseResource\Pages;

use App\Models\User;
use Filament\Actions;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectPurchaseNotification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Purchases\Resources\RequestIncorporation\ProjectPurchaseResource;

class CreateProjectPurchase extends CreateRecord
{
    protected static string $resource = ProjectPurchaseResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = session()->get('company_id');
        $data['requester_id'] = auth()->user()->id;
        return $data;
    }
    protected function afterCreate(): void
    {
        $this->record->status()->transitionTo('pendiente');
    }
}
