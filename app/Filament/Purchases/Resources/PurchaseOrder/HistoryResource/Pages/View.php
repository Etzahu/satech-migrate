<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource;
use App\Services\OrderCalculationService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class View extends ViewRecord
{
    protected static string $resource = HistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Descargar orden')
                ->color('info')
                ->visible(fn ($record) => $record->status == 'autorizada para proveedor')
                ->url(route('order.pdf.download', ['id' => $this->record->id]))
                ->icon('heroicon-m-arrow-down-tray')
                ->openUrlInNewTab(),
            Action::make('Ver pdf')
                ->color('danger')
                ->url(route('order.pdf.show', ['id' => $this->record->id]))
                ->icon('heroicon-m-document')
                ->openUrlInNewTab(),
            EditAction::make(),
        ];
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
