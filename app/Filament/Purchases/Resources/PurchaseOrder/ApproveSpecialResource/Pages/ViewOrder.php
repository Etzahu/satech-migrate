<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\ApproveSpecialResource\Pages;

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
use App\Filament\Purchases\Resources\PurchaseOrder\ApproveSpecialResource;


class ViewOrder extends ViewRecord
{
    protected static string $resource = ApproveSpecialResource::class;
    protected function getHeaderActions(): array
    {

        return [

            Actions\Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->color('success')
                ->visible(
                    fn() => (
                        $this->record->status()->canBe('autorizada para proveedor') ||
                        $this->record->status()->canBe('devuelto por dirección general') ||
                        $this->record->status()->canBe('cancelado por dirección general')) &&
                        auth()->user()->can('view_approve-level-3_purchase::order::purchaser')
                )
                ->form([
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
                    $this->record->status()->transitionTo($data['response'], ['respuesta' => $data['observation']]);
                    return redirect(ApproveSpecialResource::getUrl('index'));
                    Notification::make()
                        ->title('Respuesta enviada')
                        ->success()
                        ->send();
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
