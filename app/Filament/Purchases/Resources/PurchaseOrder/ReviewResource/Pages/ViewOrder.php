<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\ReviewResource\Pages;

use Filament\Actions;
use App\Models\PurchaseOrder;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Enums\ActionSize;
use Filament\Resources\Pages\ViewRecord;
use App\Services\OrderCalculationService;
use App\Filament\Purchases\Resources\PurchaseOrder\ReviewResource;


class ViewOrder extends ViewRecord
{
    protected static string $resource = ReviewResource::class;
    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Actions\Action::make('Ver pdf')
                    ->color('success')
                    ->url(fn(PurchaseOrder $record): string => ReviewResource::getUrl('view-pdf', ['record' => $record->id]))
            ])
                ->label('Opciones')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('primary')
                ->dropdownWidth(MaxWidth::Small)
                ->button()
        ];
    }
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
