<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\AuthorizeResource\Pages;

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
use App\Filament\Purchases\Resources\PurchaseOrder\AuthorizeResource;


class ViewOrder extends ViewRecord
{
    protected static string $resource = AuthorizeResource::class;
    protected function getHeaderActions(): array
    {
        return [
            // Nivel 2
            Actions\Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->color('success')
                ->visible(
                    fn() => ($this->record->status()->canBe('autorizada para proveedor') ||
                        $this->record->status()->canBe('devuelto por DG nivel 2') ||
                        $this->record->status()->canBe('cancelado por DG nivel 2')) && auth()->user()->can('view_approve_level-4_purchase::order::purchaser')
                )
                ->form([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'autorizada para proveedor' => 'Aprobar',
                            'devuelto por DG nivel 2' => 'Devolver',
                            'cancelado por DG nivel 2' => 'Cancelar',
                        ])
                        ->default('autorizada para proveedor')
                        ->required(),
                    Textarea::make('observation')
                        ->requiredUnless('response', 'autorizada para proveedor')
                        ->label('Observación'),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    $this->record->status()->transitionTo($data['response'], ['respuesta' => $data['observation']]);
                    Notification::make()
                        ->title('Respuesta enviada')
                        ->success()
                        ->send();
                    return redirect(AuthorizeResource::getUrl('index'));
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
