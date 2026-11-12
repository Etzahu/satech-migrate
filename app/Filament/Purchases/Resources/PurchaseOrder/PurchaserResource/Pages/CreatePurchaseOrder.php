<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseOrder extends CreateRecord
{
    protected static string $resource = PurchaserResource::class;

    public function mount($requisition = null): void
    {
        parent::mount();

        // "Crear orden" desde una pestaña que quedó en la otra empresa: se avisa antes
        // de que llene todo el formulario, en vez de rechazarlo hasta guardar.
        if ($message = PurchaserResource::otherCompanyRequisitionMessage($requisition)) {
            Notification::make()
                ->title('La requisición es de otra empresa')
                ->body($message)
                ->danger()
                ->persistent()
                ->send();

            return;
        }

        $this->data['requisition_id'] = $requisition;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $sum = 0;
        foreach ($data['condition_payment'] as $item) {
            $sum += (int) $item['value'];
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
