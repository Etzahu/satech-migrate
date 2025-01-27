<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\ChainResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Filament\Purchases\Resources\PurchaseRequisition\ChainResource;

class CreatePurchaseRequisitionApprovalChain extends CreateRecord
{
    protected static string $resource = ChainResource::class;


    protected function afterValidate(): void
    {
        $existRecord = PurchaseRequisitionApprovalChain::where('requester_id', $this->data['requester_id'])
            ->where('reviewer_id', $this->data['reviewer_id'])
            ->where('approver_id', $this->data['approver_id'])
            ->first();

        if ($existRecord) {
            Notification::make()
                ->danger()
                ->title('Error al guardar la información')
                ->body('Ya existe la cadena de aprobación.')
                ->persistent()
                ->color('danger')
                ->send();
            $this->halt();
        }
    }
    protected function afterCreate(): void
    {
        $this->record->requester->assignRole('solicita_requisicion_compra');
        $this->record->reviewer->assignRole('revisa_requisicion_compra');
        $this->record->approver->assignRole('aprueba_requisicion_compra');
        $this->record->approver->assignRole('gerente_solicitante_orden_compra');
    }
}
