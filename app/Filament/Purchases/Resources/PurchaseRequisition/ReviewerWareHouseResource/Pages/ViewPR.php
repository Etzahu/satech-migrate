<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerWareHouseResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerWareHouseResource;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewPR extends ViewRecord
{
    protected static string $resource = ReviewerWareHouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->extraAttributes(['class' => 'animate-tada-loop  animate-iteration-count-infinite'])
                ->visible(fn () => ($this->record->status()->canBe('revisión') || $this->record->status()->canBe('devuelto por almacén'))
                    && auth()->user()->hasRole('revisa_almacen_requisicion_compra'))
                ->color('success')
                ->schema([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'revisión' => 'Revisado',
                            'devuelto por almacén' => 'Devolver',
                        ])
                        ->default('revisión')
                        ->required(),
                    Textarea::make('observation')
                        ->requiredUnless('response', 'revisión')
                        ->validationMessages([
                            'required_unless' => 'El campo :attribute es obligatorio.',
                        ])
                        ->label('Observación'),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    $this->record->status()->transitionTo($data['response'], ['respuesta' => $data['observation']]);
                    Notification::make()
                        ->title('Respuesta enviada')
                        ->success()
                        ->send();

                    return redirect(ReviewerWareHouseResource::getUrl('index'));
                }),
            Action::make('Ver pdf')
                ->color('danger')
                ->icon('heroicon-m-document')
                ->url(route('requisition.pdf', ['id' => $this->record->id]))
                ->openUrlInNewTab(),
        ];
    }
}
