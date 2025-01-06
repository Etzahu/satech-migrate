<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages;

use Filament\Actions;
use App\Models\PurchaseOrder;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Services\OrderCalculationService;
use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource;



class ViewOrder extends ViewRecord
{
    protected static string $resource = PurchaserResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Solicitar')
                ->modalHeading('Enviar respuesta')
                ->color('success')
                ->visible(function () {
                    // TODO: fala la logica para que se muestre el boton una vez que el comprado agrege un precio unitario a cada item
                    return $this->record->status()->canBe('revisión gerente de compras') && $this->record->items()->count() > 0;
                })
                ->requiresConfirmation()
                ->action(function (array $data) {
                    $this->record->status()->transitionTo('revisión gerente de compras');
                    Notification::make()
                        ->title('Respuesta enviada')
                        ->success()
                        ->send();
                    return redirect(PurchaserResource::getUrl('index'));
                }),
            ActionGroup::make([
                Actions\EditAction::make(),
                Actions\Action::make('Agregar partidas de la requisición')
                    ->color('success')
                    ->url(fn(PurchaseOrder $record): string => PurchaserResource::getUrl('add-item', ['record' => $record->id])),
                // Action para cambiar de status
            ])
                ->label('Opciones')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('primary')
                ->dropdownWidth(MaxWidth::Large)
                ->button()
        ];
    }
    /*

    */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $service = new OrderCalculationService($this->record->id);
        $service->getSubtotalItems();
        $service->getTaxIva();
        $service->getRetentionIva();
        $service->getRetentionIsr();
        $service->getTotal();
        $data['total']['Subtotal'] =  $service->getSubtotalItems(true);
        $data['total']['Descuento'] =  $service->getDiscountProvider(true);
        $data['total']['IVA'] =  $service->getTaxIva(true);
        $data['total']['Retención de IVA'] =  $service->getRetentionIva(true);
        $data['total']['Retención de ISR'] =  $service->getRetentionIsr(true);
        $data['total']['Total'] =  $service->getTotal(true);
        return $data;
    }
}
