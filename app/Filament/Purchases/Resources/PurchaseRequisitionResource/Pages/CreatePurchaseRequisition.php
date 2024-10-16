<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisitionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Services\PurchaseRequisitionCreationService;
use App\Filament\Purchases\Resources\PurchaseRequisitionResource;

class CreatePurchaseRequisition extends CreateRecord
{
    protected static string $resource = PurchaseRequisitionResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $service = new PurchaseRequisitionCreationService();
        $data['folio'] = $service->generateFolio();
        $data['approval_chain_id'] = $service->getApprovalChain($data['reviewer_id'], $data['approver_id']);
        $data['company_id'] = session()->get('company_id');
        return $data;
    }
}
