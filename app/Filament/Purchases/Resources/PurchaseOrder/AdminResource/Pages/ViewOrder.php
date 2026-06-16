<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\AdminResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\AdminResource;
use App\Mail\PurchaseOrder\Notification as OrderMail;
use App\Models\ProviderEvaluation;
use App\Services\OrderCalculationService;
use App\Services\OrderService;
use App\Services\ProviderEvaluationService;
use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Mail;

class ViewOrder extends ViewRecord
{
    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('restaurar')
                ->label('Restaurar')
                ->icon('heroicon-m-arrow-uturn-left')
                ->color('success')
                ->visible(fn () => $this->record->trashed())
                ->requiresConfirmation()
                ->modalHeading('Restaurar orden')
                ->modalDescription('Se restaurará la orden y se notificará al comprador asignado por correo.')
                ->modalSubmitActionLabel('Sí, restaurar')
                ->action(function () {
                    // 'total' lo agrega el infolist solo para la vista y no es una
                    // columna real; hay que quitarlo antes de guardar o el save truena.
                    unset($this->record->total);

                    $this->record->restore();

                    $purchaser = $this->record->purchaser;
                    $notifiedByEmail = false;

                    // Notificar por correo al comprador asignado, salvo que sea gerente de compras.
                    if ($purchaser && $purchaser->email && ! $purchaser->hasRole('gerente_compras')) {
                        $data = (new OrderService)->generateDataEmail($this->record->id, 'restaurada');
                        Mail::to($purchaser->email)->send(new OrderMail($data));
                        $notifiedByEmail = true;
                    }

                    Notification::make()
                        ->title('Orden restaurada')
                        ->body($notifiedByEmail
                            ? "Se notificó por correo a {$purchaser->name}."
                            : 'No se envió correo (el comprador es gerente de compras).')
                        ->success()
                        ->send();

                    return redirect(AdminResource::getUrl('view', ['record' => $this->record]));
                }),
            Actions\Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->color('success')
                ->visible(
                    fn () => $this->record->status()->canBe('aprobado por gerente de compras') ||
                        $this->record->status()->canBe('devuelto por gerente de compras') ||
                        $this->record->status()->canBe('cancelado por gerente de compras')
                )
                ->schema([
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
                        ->validationMessages([
                            'required_unless' => 'El campo :attribute es obligatorio.',
                        ])
                        ->label('Observación'),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    unset($this->record->total);
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
                    ->url(route('order.pdf.show', ['id' => $this->record->id]))
                    ->icon('heroicon-m-document')
                    ->openUrlInNewTab(),
                Actions\Action::make('crear_evaluacion_proveedor')
                    ->label('Crear evaluación de proveedor')
                    ->icon('heroicon-m-star')
                    ->color('warning')
                    ->visible(fn () => $this->record->status === 'autorizada para proveedor')
                    ->requiresConfirmation()
                    ->modalHeading('Crear evaluación de proveedor')
                    ->modalDescription('Se creará una evaluación de proveedor para esta orden y se notificará a los evaluadores.')
                    ->action(function () {
                        $existing = ProviderEvaluation::where('purchase_order_id', $this->record->id)
                            ->where('status', 'pending')
                            ->exists();

                        if ($existing) {
                            Notification::make()
                                ->title('Ya existe una evaluación en curso')
                                ->body('Esta orden ya tiene una evaluación de proveedor pendiente.')
                                ->warning()
                                ->send();

                            return;
                        }

                        $evaluation = ProviderEvaluationService::createForOrder($this->record);

                        if (! $evaluation) {
                            Notification::make()
                                ->title('No es posible crear la evaluación')
                                ->body('La categoría de la requisición no permite evaluaciones de proveedor.')
                                ->danger()
                                ->send();

                            return;
                        }

                        Notification::make()
                            ->title('Evaluación creada correctamente')
                            ->success()
                            ->send();
                    }),
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
