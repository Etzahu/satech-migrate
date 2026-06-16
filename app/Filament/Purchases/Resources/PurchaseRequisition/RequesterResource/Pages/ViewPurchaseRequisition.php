<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Size;

class ViewPurchaseRequisition extends ViewRecord
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
                }),

            // Acciones secundarias agrupadas
            ActionGroup::make([
                EditAction::make(),
                DeleteAction::make(),
                Action::make('Ver pdf')
                    ->color('danger')
                    ->icon('heroicon-m-document')
                    ->url(route('requisition.pdf', ['id' => $this->record->id]))
                    ->openUrlInNewTab(),
            ])
                ->label('Opciones')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size(Size::Small)
                ->color('gray')
                ->button(),
        ];
    }
}
