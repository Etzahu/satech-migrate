<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\AuthorizeResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\AuthorizeResource;
use App\Services\OrderCalculationService;
use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;

class ViewOrder extends ViewRecord
{
    protected static string $resource = AuthorizeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Nivel 2
            Actions\Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->extraAttributes(['class' => 'animate-tada-loop  animate-iteration-count-infinite'])
                ->color('success')
                ->visible(
                    fn () => ($this->record->status()->canBe('aprobado por DG nivel 2') ||
                        $this->record->status()->canBe('devuelto por DG nivel 2') ||
                        $this->record->status()->canBe('cancelado por DG nivel 2')) && auth()->user()->hasRole('autoriza_nivel-2-orden_compra')
                )
                ->schema([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'aprobado por DG nivel 2' => 'Aprobar',
                            'devuelto por DG nivel 2' => 'Devolver',
                            'cancelado por DG nivel 2' => 'Cancelar',
                        ])
                        ->default('aprobado por DG nivel 2')
                        ->required(),
                    Textarea::make('observation')
                        ->requiredUnless('response', 'aprobado por DG nivel 2')
                        ->validationMessages([
                            'required_unless' => 'El campo :attribute es obligatorio.',
                        ])
                        ->label('Observación'),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    unset($this->record->total); // evitar error de serialización del total calculado
                    $this->record->status()->transitionTo($data['response'], ['respuesta' => $data['observation']]);

                    // Antes el select aprobaba saltando directo a `autorizada para
                    // proveedor`, así que `aprobado por DG nivel 2` no se registró
                    // nunca y la firma de Dirección General salía vacía en el
                    // PDF de toda orden que superara el límite. Ahora deja traza.
                    if ($data['response'] === 'aprobado por DG nivel 2') {
                        $this->record->status()->transitionTo('autorizada para proveedor');
                    }
                    Notification::make()
                        ->title('Respuesta enviada')
                        ->success()
                        ->send();

                    return redirect(AuthorizeResource::getUrl('index'));
                }),

            ActionGroup::make([
                Actions\Action::make('Ver pdf')
                    ->color('danger')
                    ->url(route('order.pdf.show', ['id' => $this->record->id]))
                    ->icon('heroicon-m-document')
                    ->openUrlInNewTab(),
            ])
                ->label('Opciones')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('primary')
                ->dropdownWidth(Width::Small)
                ->button(),
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
