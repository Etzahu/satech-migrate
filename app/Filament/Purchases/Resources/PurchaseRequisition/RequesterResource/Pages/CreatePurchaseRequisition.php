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

    protected const ROLE_LABELS = [
        'requester' => 'Solicita',
        'reviewer' => 'Revisa',
        'approver' => 'Aprueba',
        'authorizer' => 'Autoriza',
    ];


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

        // Se resuelve la cadena hasta el momento del guardado: alguien pudo
        // desactivarse mientras el formulario estaba abierto.
        $chain = $service->findApprovalChain($data['reviewer_id'], $data['approver_id']);

        if (blank($chain)) {
            Notification::make()
                ->danger()
                ->title('Hubo un error')
                ->body('No se encontró una cadena de aprobación para el flujo seleccionado.')
                ->persistent()
                ->send();
            $this->halt();
        }

        if ($inactive = $chain->getInactiveUsers()) {
            $names = collect($inactive)
                ->keys()
                ->map(fn (string $role) => static::ROLE_LABELS[$role].': '.($chain->{$role}?->name ?? 'usuario eliminado'))
                ->implode(', ');

            Notification::make()
                ->danger()
                ->title('Cadena de aprobación no disponible')
                ->body("La cadena seleccionada tiene participantes inactivos ({$names}). Elija otro flujo de aprobación o solicite al administrador que actualice la cadena.")
                ->persistent()
                ->send();
            $this->halt();
        }

        $data['folio'] = $service->generateFolio();
        $data['approval_chain_id'] = $chain->id;
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
