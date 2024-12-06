<?php

namespace App\Filament\Purchases\Resources\PurchaseOrderResource\Pages;

use Filament\Actions;
use App\Services\OrderService;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Purchases\Resources\PurchaseOrderResource;

class CreatePurchaseOrder extends CreateRecord
{
    protected static string $resource = PurchaseOrderResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['folio'] = 'N/A';
        $data['purchaser_user_id'] = auth()->user()->id;
        $data['company_id'] = session()->get('company_id');
        // $data['requisition_id'] = 1;
        return $data;
    }
    protected function afterCreate(): void
    {
        $service = new OrderService();
        $this->record->folio = $service->generateFolio($this->record->requisition_id);
        $this->record->save();
    }
}
