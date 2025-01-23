<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\AdminResource\Pages;

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
use App\Filament\Purchases\Resources\PurchaseOrder\AdminResource;


class ViewOrder extends ViewRecord
{
    protected static string $resource = AdminResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->color('success')
                ->visible(
                    fn() =>
                    $this->record->status()->canBe('aprobado por gerente de compras') ||
                        $this->record->status()->canBe('devuelto por gerente de compras') ||
                        $this->record->status()->canBe('cancelado por gerente de compras')
                )
                ->form([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'aprobado por gerente de compras' => 'Aprobar',
                            'devuelto por gerente de compras' => 'Devolver',
                            'cancelado por gerente de compras' => 'Cancelar',
                        ])
                        ->default('aprobado por gerente de compras')
                        ->required(),
                    Textarea::make('observation')
                        ->requiredUnless('response', 'aprobado por gerente de compras')
                        ->label('Observación'),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    $this->record->status()->transitionTo($data['response'], ['respuesta' => $data['observation']]);
                    Notification::make()
                        ->title('Respuesta enviada')
                        ->success()
                        ->send();
                    return redirect(AdminResource::getUrl('index'));
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
    // protected function mutateFormDataBeforeFill(array $data): array
    // {
    //     $service = new OrderCalculationService($this->record->id);
    //     $service->getSubtotalItems();
    //     $service->getTaxIva();
    //     $service->getRetentionIva();
    //     $service->getRetentionIsr();
    //     $service->getTotal();
    //     $data['total']['Subtotal'] =  $service->getSubtotalItems(true);
    //     $data['total']['Descuento'] =  $service->getDiscountProvider(true);
    //     $data['total']['IVA'] =  $service->getTaxIva(true);
    //     $data['total']['Retención de IVA'] =  $service->getRetentionIva(true);
    //     $data['total']['Retención de ISR'] =  $service->getRetentionIsr(true);
    //     $data['total']['Total'] =  $service->getTotal(true);
    //     return $data;
    // }
}
