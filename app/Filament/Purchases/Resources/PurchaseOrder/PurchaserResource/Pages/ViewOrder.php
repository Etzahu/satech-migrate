<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages;

use Filament\Actions;
use App\Models\PurchaseOrder;
use Filament\Infolists\Infolist;
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
                    // TODO falta agregar la logica para habilitar el boton cuando la orden se rechazo y debe comenzar el proceso
                    // TODO: fala la logica para que se muestre el boton una vez que el comprado agrege un precio unitario a cada item
                    $items = $this->record->items->pluck('unit_price');
                    $hasZeroQuantity = $items->contains(function ($item) {
                        return $item === 0;
                    });
                    if ($hasZeroQuantity) {
                       return false;
                    }
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
                    ->visible(function () {
                        // dd($this->record);
                        $orders = $this->record->requisition->orders;
                        $itemsRequisition = $this->record->requisition->items->pluck('product_id');
                        $itemsWithOrder = [];
                        foreach ($orders as $order) {
                            $items = $order->items?->pluck('product_id')->all();
                            $itemsWithOrder = array_merge($itemsWithOrder, $items);
                        }
                        return count($itemsRequisition) == count($itemsWithOrder) ? false : true;
                    })
                    ->color('success')
                    ->url(fn(PurchaseOrder $record): string => PurchaserResource::getUrl('add-item', ['record' => $record->id])),
                // Action para cambiar de status
            ])
                ->label('Opciones')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('primary')
                ->visible($this->record->status == 'borrador')
                ->dropdownWidth(MaxWidth::Large)
                ->button()
        ];
    }
    /*

    */
    public function infolist(Infolist $infolist): Infolist
    {
        $service = new OrderCalculationService($this->record->id);
        $this->record->total = [
            'Subtotal' => $service->getSubtotalItems(true),
            'Descuento' =>  $service->getDiscountProvider(true),
            'IVA' =>  $service->getTaxIva(true),
            'Retención de IVA' =>  $service->getRetentionIva(true),
            'Retención de ISR' =>  $service->getRetentionIsr(true),
            'Total' =>  $service->getTotal(true),
        ];
        return static::getResource()::infolist($infolist);
    }
}
