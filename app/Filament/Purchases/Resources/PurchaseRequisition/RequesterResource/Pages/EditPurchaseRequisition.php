<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages;

use Filament\Actions;
use Livewire\Attributes\On;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\ActionSize;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource;


#[On('refreshOwner')]
class EditPurchaseRequisition extends EditRecord
{
    protected static string $resource = RequesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('Enviar requisición')
                    ->color('success')
                    ->requiresConfirmation()

                    ->visible(
                        $this->record->status()->canBe('revisión por almacén') && $this->record->items->count() > 0 && filled($this->record->category)
                    )
                    ->action(function () {
                        if ($this->record->category == 'servicio') {
                            $this->record->status()->transitionTo('revisión');
                        } else {
                            $this->record->status()->transitionTo('revisión por almacén');
                        }
                        Notification::make()
                            ->title('Requisición enviada')
                            ->success()
                            ->send();
                    }),
                Actions\ViewAction::make(),
                Actions\DeleteAction::make(),
            ])
                ->label('Opciones')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size(ActionSize::Small)
                ->color('primary')
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
