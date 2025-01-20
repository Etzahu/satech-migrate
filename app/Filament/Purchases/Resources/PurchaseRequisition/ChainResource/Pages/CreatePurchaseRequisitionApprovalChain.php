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
        $this->record->requester->assignRole('solicitante_requisicion_compra');
        $this->record->reviewer->assignRole('revisor_requisicion_compra');
        $this->record->approver->assignRole('autorizador_requisicion_compra');
    }
}
