<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\ChainResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\ChainResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseRequisitionApprovalChain extends CreateRecord
{
    protected static string $resource = ChainResource::class;

    protected function afterCreate(): void
    {
        $this->record->requester->assignRole('solicita_requisicion_compra');
        $this->record->reviewer->assignRole('revisa_requisicion_compra');
        $this->record->approver->assignRole('aprueba_requisicion_compra');
        $this->record->approver->assignRole('gerente_solicitante_orden_compra');
    }
}
