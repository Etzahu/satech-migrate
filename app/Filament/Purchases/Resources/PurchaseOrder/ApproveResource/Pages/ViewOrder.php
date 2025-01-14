<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\ApproveResource\Pages;

use Money\Money;
use Filament\Actions;
use App\Models\PurchaseOrder;
use Filament\Infolists\Infolist;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\ActionSize;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Services\OrderCalculationService;
use App\Filament\Purchases\Resources\PurchaseOrder\ApproveResource;


class ViewOrder extends ViewRecord
{
    protected static string $resource = ApproveResource::class;
    protected function getHeaderActions(): array
    {
        // aprobado por DG nivel 1
        return [
            // Nivel 1
            Actions\Action::make('Capturar respuesta-1')
                ->modalHeading('Enviar respuesta')
                ->color('success')
                ->visible(
                    fn() => ($this->record->status()->canBe('aprobada para emisión') ||
                        $this->record->status()->canBe('aprobado por DG nivel 1') ||
                        $this->record->status()->canBe('devuelto por DG nivel 1') ||
                        $this->record->status()->canBe('cancelado por DG nivel 1')) &&
                        auth()->user()->can('view_approve-level-3_purchase::order::purchaser')
                )
                ->form([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'aprobado por DG nivel 1' => 'Aprobar',
                            'devuelto por DG nivel 1' => 'Devolver',
                            'cancelado por DG nivel 1' => 'Cancelar',
                        ])
                        ->default('aprobado por DG nivel 1')
                        ->required(),
                    Textarea::make('observation')
                        ->requiredUnless('response', 'aprobado por DG nivel 1')
                        ->label('Observación'),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    // validar el tipo de moneda
                    if ($data['response'] == 'aprobado por DG nivel 1') {
                        $min = 0;
                        $max = 0;
                        if ($this->record->currency == 'USD') {
                            $min = Money::USD(1);
                            $max = Money::USD(10000);
                        }
                        if ($this->record->currency == 'MXN') {
                            $min = Money::MXN(1);
                            $max = Money::MXN(200000);
                        }
                        $service = new OrderCalculationService($this->record->id);
                        $total = $service->getTotal();
                        if ($total >= $min && $total <= $max) {
                            $this->record->status()->transitionTo('aprobada para emisión');
                        }
                        if ($total > $max) {
                            $this->record->status()->transitionTo($data['response'], ['respuesta' => $data['observation']]);
                        }
                    }
                    Notification::make()
                        ->title('Respuesta enviada')
                        ->success()
                        ->send();
                    return redirect(ApproveResource::getUrl('index'));
                }),
            // Nivel 2
            Actions\Action::make('Capturar respuesta-2')
                ->modalHeading('Enviar respuesta')
                ->color('success')
                ->visible(
                    fn() => ($this->record->status()->canBe('aprobada para emisión') ||
                        $this->record->status()->canBe('devuelto por DG nivel 2') ||
                        $this->record->status()->canBe('cancelado por DG nivel 2')) && auth()->user()->can('view_approve_level-4_purchase::order::purchaser')
                )
                ->form([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'aprobada para emisión' => 'Aprobar',
                            'devuelto por DG nivel 2' => 'Devolver',
                            'cancelado por DG nivel 2' => 'Cancelar',
                        ])
                        ->default('aprobada para emisión')
                        ->required(),
                    Textarea::make('observation')
                        ->requiredUnless('response', 'aprobada para emisión')
                        ->label('Observación'),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    $this->record->status()->transitionTo($data['response'], ['respuesta' => $data['observation']]);
                    Notification::make()
                        ->title('Respuesta enviada')
                        ->success()
                        ->send();
                    return redirect(ApproveResource::getUrl('index'));
                }),


            ActionGroup::make([
                Actions\Action::make('Ver pdf')
                    ->color('success')
                    ->url(fn(PurchaseOrder $record): string => ApproveResource::getUrl('view-pdf', ['record' => $record->id]))
            ])
                ->label('Opciones')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('primary')
                ->dropdownWidth(MaxWidth::Small)
                ->button()
        ];
    }

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
