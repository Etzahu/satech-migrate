<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\ApproveResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\ApproveResource;
use App\Services\OrderCalculationService;
use App\Services\PurchaseOrderChainResolver;
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
    protected static string $resource = ApproveResource::class;

    protected function getHeaderActions(): array
    {
        // aprobado por DG nivel 1
        return [
            // Nivel 1
            Actions\Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->extraAttributes(['class' => 'animate-tada-loop  animate-iteration-count-infinite'])
                ->color('success')
                ->visible(
                    fn () => (
                        $this->record->status()->canBe('aprobado por DG nivel 1') ||
                        $this->record->status()->canBe('devuelto por DG nivel 1') ||
                        $this->record->status()->canBe('cancelado por DG nivel 1')) &&
                        app(PurchaseOrderChainResolver::class)->isAuthorizer($this->record, auth()->user())
                )
                ->schema([
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
                    unset($this->record->total); // evitar error de serialización del total calculado
                    $this->record->status()->transitionTo($data['response'], ['respuesta' => $data['observation']]);

                    // La condición de monto se movió al final del flujo: ahora se
                    // evalúa después de la liberación de Dirección Administrativa
                    // (PurchaseOrderFlowService). Este nivel solo aprueba.
                    Notification::make()
                        ->title('Respuesta enviada')
                        ->success()
                        ->send();

                    return redirect(ApproveResource::getUrl('index'));
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
