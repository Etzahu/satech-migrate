<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\HistoryResource\Pages;

use Filament\Forms\Get;

use Filament\Actions\Action;
use Filament\Infolists\Infolist;
use App\Services\PRInfolistService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use App\Filament\Purchases\Resources\PurchaseRequisition\HistoryResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class View extends ViewRecord
{
    protected static string $resource = HistoryResource::class;

       protected function getHeaderActions(): array
    {
        return [
            Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->visible(fn() => $this->record->status()->canBe('aprobado por DG') || $this->record->status()->canBe('devuelto por DG') || $this->record->status()->canBe('cancelado por DG'))
                ->color('success')
                ->form([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'aprobado por DG' => 'Aprobar',
                            'devuelto por DG' => 'Devolver',
                            'cancelado por DG' => 'Cancelar',
                        ])
                        ->default('aprobado por DG')
                        ->required(),
                    Textarea::make('observation')
                        ->requiredUnless('response', 'aprobado por DG')
                        ->label('Observación'),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    $this->record->status()->transitionTo($data['response'], ['respuesta' => $data['observation']]);
                    Notification::make()
                        ->title('Respuesta enviada')
                        ->success()
                        ->send();
                    return redirect(HistoryResource::getUrl('index'));
                }),
            Action::make('Ver pdf')
                ->color('danger')
                ->url(route('requisition.pdf', ['id' => $this->record->id]))
                ->icon('heroicon-m-document')
                ->openUrlInNewTab()
        ];
    }

}
