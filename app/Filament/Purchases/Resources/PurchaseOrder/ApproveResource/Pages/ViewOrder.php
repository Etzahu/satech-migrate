<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\ApproveResource\Pages;

use Money\Money;
use Filament\Actions;
use Brick\Math\BigDecimal;
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
            Actions\Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->color('success')
                ->visible(
                    fn() => (
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
                        ->validationMessages([
                            'required_unless' => 'El campo :attribute es obligatorio.',
                        ])
                        ->label('Observación'),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    $this->record->status()->transitionTo($data['response'], ['respuesta' => $data['observation']]);
                    if ($data['response'] == 'aprobado por DG nivel 1') {
                        $service = new OrderCalculationService($this->record->id);

                        //Proveedor GPT Ingeniería y Manufactura, S.A. de C.V.
                        if ( in_array($this->record->provider->id,[427,425,332])) {
                            $this->record->status()->transitionTo('autorizada para proveedor');
                            Notification::make()
                                ->title('Respuesta enviada')
                                ->success()
                                ->send();
                            return redirect(ApproveResource::getUrl('index'));
                        }

                        if ($service->isOrderTotalBetweenLimits()) {
                            $this->record->status()->transitionTo('autorizada para proveedor');
                        }
                    }
                }),



            ActionGroup::make([
                Actions\Action::make('Ver pdf')
                    ->color('danger')
                    ->url(route('order.pdf', ['id' => $this->record->id]))
                    ->icon('heroicon-m-document')
                    ->openUrlInNewTab(),
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
