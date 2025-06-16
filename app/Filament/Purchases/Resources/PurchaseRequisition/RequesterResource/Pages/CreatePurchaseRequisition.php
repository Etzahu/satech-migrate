<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Services\PurchaseRequisitionCreationService;
use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource;

class CreatePurchaseRequisition extends CreateRecord
{
    protected static string $resource = RequesterResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (blank(auth()->user()->management)) {
            Notification::make()
                ->danger()
                ->title('Hubo un error')
                ->body('No cuenta con una gerencia asignada.')
                ->persistent()
                ->color('danger')
                ->send();
            $this->halt();
        }
        if (blank(auth()->user()->approvalChainsPurchaseRequisition)) {
            Notification::make()
                ->danger()
                ->title('Hubo un error')
                ->body('No cuenta con una cadena de aprobación asignada.')
                ->persistent()
                ->color('danger')
                ->send();
            $this->halt();
        }

        $service = new PurchaseRequisitionCreationService();
        $data['folio'] = $service->generateFolio();
        $data['approval_chain_id'] = $service->getApprovalChain($data['reviewer_id'], $data['approver_id']);
        // if (!$data['confidential']) {
        // } else {
        //     $data['approval_chain_id'] = $service->getApprovalChainConfidential();
        // }
        $data['company_id'] = session()->get('company_id');
        return $data;
    }
    protected function beforeFill()
    {
        if (blank(auth()->user()->management)) {
            Notification::make()
                ->danger()
                ->title('Hubo un error')
                ->body('No cuenta con una gerencia asignada.')
                ->persistent()
                ->color('danger')
                ->send();
        }
        if (blank(auth()->user()->approvalChainsPurchaseRequisition)) {
            Notification::make()
                ->danger()
                ->title('Hubo un error')
                ->body('No cuenta con una cadena de aprobación asignada.')
                ->persistent()
                ->color('danger')
                ->send();
        }
    }
}
