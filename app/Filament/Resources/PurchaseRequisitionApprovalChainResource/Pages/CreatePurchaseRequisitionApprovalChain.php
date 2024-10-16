<?php

namespace App\Filament\Resources\PurchaseRequisitionApprovalChainResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Filament\Resources\PurchaseRequisitionApprovalChainResource;

class CreatePurchaseRequisitionApprovalChain extends CreateRecord
{
    protected static string $resource = PurchaseRequisitionApprovalChainResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $existRecord = PurchaseRequisitionApprovalChain::where('requester_id', $data['requester_id'])
            ->where('reviewer_id', $data['reviewer_id'])
            ->where('approver_id', $data['approver_id'])
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
        } else {
            return $data;
        }
    }
}
