<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource;
use App\Models\PurchaseOrder;
use App\Services\OrderCalculationService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class ViewOrder extends ViewRecord
{
    protected static string $resource = PurchaserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Descargar orden')
                ->color('info')
                ->visible(fn ($record) => $record->status == 'autorizada para proveedor')
                ->url(route('order.pdf.download', ['id' => $this->record->id]))
                ->icon('heroicon-m-arrow-down-tray')
                ->openUrlInNewTab(),
            Actions\Action::make('Solicitar')
                ->label('Enviar a revisión')
                ->extraAttributes(['class' => 'animate-tada-loop  animate-iteration-count-infinite'])
                ->visible(function () {
                    if ($this->record->isArchived()) {
                        return false;
                    }

                    // TODO: fala la logica para que se muestre el boton una vez que el comprado agrege un precio unitario a cada item
                    $items = $this->record->items->pluck('unit_price');
                    $hasZeroQuantity = $items->contains(function ($item) {
                        return $item === 0;
                    });
                    if ($hasZeroQuantity) {
                        return false;
                    }

                    return ($this->record->status()->canBe('revisión gerente de compras') || $this->record->status()->canBe('revision por dirección general')) && $this->record->items()->count() > 0;
                })
                ->action(function () {
                    // dd($this->record->provider->approval_chain);
                    unset($this->record->total);
                    if ($this->record->provider->approval_chain == 'especial') {
                        $this->record->status()->transitionTo('revision por dirección general');
                    } else {
                        if (PurchaserResource::haltIfSignersInactive($this->record, 'revisión gerente de compras')) {
                            return;
                        }

                        $this->record->status()->transitionTo('revisión gerente de compras');
                    }
                    Notification::make()
                        ->title('Orden enviada a revisión')
                        ->success()
                        ->send();

                    return redirect(PurchaserResource::getUrl('index'));
                })
                ->requiresConfirmation() // This makes the action require confirmation
                ->modalHeading('Enviar a revisión')
                ->modalDescription(fn () => $this->record->provider->approval_chain == 'especial' ? "¿Está segura/o de enviar esta orden a revisión?\nTu orden seguirá un proceso de aprobación rápido por ser un proveedor especial." : '¿Está segura/o de enviar esta orden a revisión?')
                ->color(fn () => $this->record->provider->approval_chain == 'especial' ? 'danger' : 'success')
                ->modalSubmitActionLabel('Sí, enviar a revisión'),

            // Archivada solo se ve: para trabajarla primero se desarchiva.
            Actions\Action::make('unarchive')
                ->label('Desarchivar')
                ->icon('heroicon-m-arrow-uturn-left')
                ->color('gray')
                ->visible(fn (PurchaseOrder $record): bool => $record->isArchived())
                ->action(function (PurchaseOrder $record): void {
                    $record->unarchive();

                    Notification::make()
                        ->title('Orden desarchivada')
                        ->success()
                        ->send();
                }),
            Actions\EditAction::make()
                ->hidden(fn (PurchaseOrder $record): bool => $record->isArchived()),
            Actions\DeleteAction::make()
                ->visible(fn ($record) => $record->status == 'borrador'),
            Actions\Action::make('Reabrir para edición')
                ->visible(fn (PurchaseOrder $record): bool => $record->status == 'autorizada para proveedor' && ! $record->isArchived())
                ->requiresConfirmation()
                ->action(function () {
                    unset($this->record->total); // evitar error de serialización del total calculado
                    $this->record->status()->transitionTo('reabierta para edición');
                }),
            Actions\Action::make('Ver pdf')
                ->color('gray')
                ->url(route('order.pdf.show', ['id' => $this->record->id]))
                ->icon('heroicon-m-document')
                ->openUrlInNewTab(),
            Actions\Action::make('Agregar partidas de la requisición')
                ->visible(function () {
                    if ($this->record->isArchived()) {
                        return false;
                    }

                    if ($this->record->status !== 'borrador' && $this->record->status !== 'reabierta para edición') {
                        return false;
                    }
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
                ->url(fn (PurchaseOrder $record): string => PurchaserResource::getUrl('add-item', ['record' => $record->id])),

        ];
    }

    public function getSubheading(): string|Htmlable|null
    {
        return $this->record->isArchived()
            ? 'Orden archivada. Desarchívala para editarla o enviarla a revisión.'
            : null;
    }

    public function infolist(Schema $infolist): Schema
    {
        $service = new OrderCalculationService($this->record->id);
        $this->record->total = [
            'Subtotal' => $service->getSubtotalItems(true),
            'Descuento' => $service->getDiscountProvider(true),
            'IVA' => $service->getTaxIva(true),
            'Retención de IVA' => $service->getRetentionIva(true),
            'Retención de ISR' => $service->getRetentionIsr(true),
            'Total' => $service->getTotal(true),
        ];

        return static::getResource()::infolist($infolist);
    }
}

// order.pd
