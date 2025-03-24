<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages;

use Filament\Actions;
use App\Services\OrderService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource;


class CreatePurchaseOrder extends CreateRecord
{
    protected static string $resource = PurchaserResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $sum = 0;
        foreach ($data['condition_payment'] as $item) {
            $sum += (int)$item['value'];
        }
        if ($sum != 100) {
            Notification::make()
                ->title('Las condiciones de pago deben dar el 100%')
                ->danger()
                ->color('danger')
                ->persistent()
                ->send();
            $this->halt();
        }
        $data['folio'] = 'N/A';
        $data['purchaser_user_id'] = auth()->user()->id;
        $data['company_id'] = session()->get('company_id');
        // $data['requisition_id'] = 1;
        return $data;
    }
}
