<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\ReviewResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\ReviewResource;
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
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->extraAttributes(['class' => 'animate-tada-loop  animate-iteration-count-infinite'])
                ->color('success')
                ->visible(
                    fn () => ($this->record->status()->canBe('aprobado por gerente solicitante') ||
                        $this->record->status()->canBe('devuelto por gerente solicitante') ||
                        $this->record->status()->canBe('cancelado por gerente solicitante')) &&
                        app(PurchaseOrderChainResolver::class)->isApprover($this->record, auth()->user())
                )
                ->schema([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'aprobado por gerente solicitante' => 'Aprobar',
                            'devuelto por gerente solicitante' => 'Devolver',
                            'cancelado por gerente solicitante' => 'Cancelar',
                        ])
                        ->default('aprobado por gerente solicitante')
                        ->required(),
                    Textarea::make('observation')
                        ->requiredUnless('response', 'aprobado por gerente solicitante')
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

                    return redirect(ReviewResource::getUrl('index'));
                }),
            ActionGroup::make([
                Actions\Action::make('Ver pdf')
                    ->color('success')
                    ->url(route('order.pdf.show', ['id' => $this->record->id]))
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
