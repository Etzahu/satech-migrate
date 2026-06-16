<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource;
use App\Models\PurchaseRequisitionApprovalChain;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Size;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;

#[On('refreshOwner')]
class EditPurchaseRequisition extends EditRecord
{
    protected static string $resource = RequesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Botón principal, fuera del grupo → siempre visible
            Action::make('enviarRevision')
                ->label('Enviar a revisión')
                ->icon('heroicon-m-paper-airplane')
                ->color('success')

                ->button()
                ->extraAttributes(['class' => 'animate-tada-loop  animate-iteration-count-infinite'])
                ->requiresConfirmation()
                ->modalHeading('Enviar requisición a revisión')
                ->modalDescription('Una vez enviada, la requisición entrará al flujo de aprobación y ya no podrás editarla.')
                ->modalSubmitActionLabel('Sí, enviar')
                ->visible(
                    $this->record->status()->canBe('revisión por almacén') && $this->record->items->count() > 0 && filled($this->record->category)
                )
                ->action(function () {
                    if (session()->get('company_id') == 1) { // ID 1:GPT IM
                        $this->record->status()->transitionTo('revisión por almacén');
                    }
                    if ($this->record->category == 'servicio') {
                        $this->record->status()->transitionTo('revisión');
                    } else {
                        $this->record->status()->transitionTo('revisión por almacén');
                    }

                    Notification::make()
                        ->title('Requisición enviada')
                        ->success()
                        ->send();

                    return redirect(RequesterResource::getUrl('view', ['record' => $this->record]));
                }),

            // Acciones secundarias agrupadas
            ActionGroup::make([
                Actions\ViewAction::make(),
                Actions\DeleteAction::make(),
            ])
                ->label('Opciones')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size(Size::Small)
                ->color('gray')
                ->button(),
        ];
    }

    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     // Validación adicional antes de guardar
    //     if (blank($data['category'])) {
    //         throw ValidationException::withMessages([
    //             'category' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
    //         ]);
    //     }
    //     return $data;
    // }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $chain = PurchaseRequisitionApprovalChain::find($data['approval_chain_id']);
        $data['reviewer_id'] = $chain->reviewer_id;
        $data['approver_id'] = $chain->approver_id;

        return $data;
    }
}
