<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource;
use App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Size;

class View extends ViewRecord
{
    protected static string $resource = AssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('Crear orden')
                    ->color('success')
                    ->icon('heroicon-m-plus')
                    ->url(PurchaserResource::getUrl('create', ['requisition' => $this->record]))
                    ->visible($this->record->status !== 'cerrada'),
                Action::make('Ver pdf')
                    ->color('danger')
                    ->icon('heroicon-m-document')
                    ->url(route('requisition.pdf', ['id' => $this->record->id]))
                    ->openUrlInNewTab(),
                Action::make('Devolver')
                    ->requiresConfirmation()
                    ->visible($this->record->status()->canBe('devuelto por comprador'))
                    ->modalHeading('Devolver la requisición')
                    ->modalDescription(function ($record) {
                        $quantity = $record->orders->count();
                        if ($quantity > 0) {
                            return '¿Estás seguro de hacer esto?. La requisición contiene ordenes, las cuales se borrarán.';
                        } else {
                            return '¿Estás seguro de hacer esto?';
                        }
                    })
                    ->schema([
                        Textarea::make('observation')
                            ->label('Motivo')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        try {
                            $this->record->status()->transitionTo('devuelto por comprador', ['respuesta' => $data['observation']]);
                            $this->record->orders()->delete();
                            Notification::make()
                                ->title('Se devolvió la requisición')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            logger()->error($e->getMessage());
                            Notification::make()
                                ->title('Ocurrió un error')
                                ->danger()
                                ->send();
                        }
                    }),
                Action::make('Cerrar')
                    ->requiresConfirmation()
                    ->visible($this->record->status !== 'cerrada')
                    ->modalHeading('Cerrar la requisición')
                    ->schema([
                        Textarea::make('observation')
                            ->label('Motivo o comentarios')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        try {
                            $this->record->status()->transitionTo('cerrada', ['respuesta' => $data['observation']]);
                            Notification::make()
                                ->title('Se cerro la requisición')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            logger()->error($e->getMessage());
                            Notification::make()
                                ->title('Ocurrió un error')
                                ->danger()
                                ->send();
                        }
                    }),

            ])
                ->label('Opciones')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size(Size::Small)
                ->color('primary')
                ->button(),
        ];
    }
}
