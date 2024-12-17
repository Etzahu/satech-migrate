<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\ApproveResource\Pages;

use Filament\Actions;
use App\Models\PurchaseOrder;
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
                    fn() =>
                    $this->record->status()->canBe('aprobado por DG nivel 1') ||
                        $this->record->status()->canBe('devuelto por DG nivel 1') ||
                        $this->record->status()->canBe('cancelado por DG nivel 1')
                )
                ->form([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'aprobado por DG nivel 1' => 'Aprobar',
                            'devuelto por DG nivel 1' => 'Devolver',
                            'cancelado por DG nivel 1' => 'Cancelar',
                        ])
                        ->default('aprobado por gerente de compras')
                        ->required(),
                    Textarea::make('observation')
                        ->requiredUnless('response', 'aprobado por DG nivel 1')
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
            // Nivel 2
            Actions\Action::make('Capturar respuesta 2')
                ->modalHeading('Enviar respuesta')
                ->color('success')
                ->visible(
                    fn() =>
                    $this->record->status()->canBe('revision por DG nivel 2')
                )
                ->form([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'aprobada para emisión' => 'Aprobar',
                            'devuelto por DG nivel 2' => 'Devolver',
                            'cancelado por DG nivel 2' => 'Cancelar',
                        ])
                        ->default('aprobado por gerente de compras')
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
