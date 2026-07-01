<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\ApproveSpecialResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\ApproveSpecialResource;
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
    protected static string $resource = ApproveSpecialResource::class;

    protected function getHeaderActions(): array
    {

        return [

            Actions\Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->extraAttributes(['class' => 'animate-tada-loop  animate-iteration-count-infinite'])
                ->color('success')
                ->visible(
                    fn () => (
                        $this->record->status()->canBe('autorizada para proveedor') ||
                        $this->record->status()->canBe('devuelto por dirección general') ||
                        $this->record->status()->canBe('cancelado por dirección general')) &&
                        auth()->user()->hasRole('autoriza_nivel-1-orden_compra')
                )
                ->schema([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'autorizada para proveedor' => 'Aprobar',
                            'devuelto por dirección general' => 'Devolver',
                            'cancelado por dirección general' => 'Cancelar',
                        ])
                        ->default('autorizada para proveedor')
                        ->required(),
                    Textarea::make('observation')
                        ->requiredUnless('response', 'autorizada para proveedor')
                        ->validationMessages([
                            'required_unless' => 'El campo :attribute es obligatorio.',
                        ])
                        ->label('Observación'),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    unset($this->record->total); // evitar error de serialización del total calculado
                    $this->record->status()->transitionTo($data['response'], ['respuesta' => $data['observation']]);

                    Notification::make()
                        ->title('Respuesta enviada')
                        ->success()
                        ->send();

                    return redirect(ApproveSpecialResource::getUrl('index'));
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
