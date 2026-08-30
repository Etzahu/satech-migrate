<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\ReleaseResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\ReleaseResource;
use App\Services\OrderCalculationService;
use App\Services\PurchaseOrderFlowService;
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
    protected static string $resource = ReleaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Liberación · Dirección Administrativa
            Actions\Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->extraAttributes(['class' => 'animate-tada-loop  animate-iteration-count-infinite'])
                ->color('success')
                ->visible(
                    fn () => ($this->record->status()->canBe('liberado por dirección administrativa') ||
                        $this->record->status()->canBe('devuelto por liberación') ||
                        $this->record->status()->canBe('cancelado por liberación')) && auth()->user()->hasRole('libera_orden_compra')
                )
                ->schema([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'liberado por dirección administrativa' => 'Liberar',
                            'devuelto por liberación' => 'Devolver',
                            'cancelado por liberación' => 'Cancelar',
                        ])
                        ->default('liberado por dirección administrativa')
                        ->required(),
                    Textarea::make('observation')
                        ->requiredUnless('response', 'liberado por dirección administrativa')
                        ->validationMessages([
                            'required_unless' => 'El campo :attribute es obligatorio.',
                        ])
                        ->label('Observación'),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    unset($this->record->total); // evitar error de serialización del total calculado
                    $this->record->status()->transitionTo($data['response'], ['respuesta' => $data['observation']]);

                    // Si la orden no supera el límite, la liberación es el último
                    // paso del flujo; si lo supera se queda esperando a
                    // Dirección General CA, que es la última aprobación.
                    if ($data['response'] === 'liberado por dirección administrativa') {
                        (new PurchaseOrderFlowService)->advanceAfterRelease($this->record);
                    }

                    Notification::make()
                        ->title('Respuesta enviada')
                        ->success()
                        ->send();

                    return redirect(ReleaseResource::getUrl('index'));
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
