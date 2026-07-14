<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerResource;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class View extends ViewRecord
{
    protected static string $resource = ReviewerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->extraAttributes(['class' => 'animate-tada-loop  animate-iteration-count-infinite'])
                ->visible(fn () => (
                    $this->record->status()->canBe('aprobado por revisor') ||
                     $this->record->status()->canBe('devuelto por revisor') ||
                      $this->record->status()->canBe('cancelado por revisor'))
                    && auth()->user()->hasRole('revisa_requisicion_compra'))
                ->color('success')
                ->schema([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'aprobado por revisor' => 'Aprobar',
                            'devuelto por revisor' => 'Devolver',
                            'cancelado por revisor' => 'Cancelar',
                        ])
                        ->default('aprobado por revisor')
                        ->required(),
                    Textarea::make('observation')
                        ->requiredUnless('response', 'aprobado por revisor')
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

                    return redirect(ReviewerResource::getUrl('index'));
                }),
            Action::make('Ver pdf')
                ->color('danger')
                ->url(route('requisition.pdf', ['id' => $this->record->id]))
                ->icon('heroicon-m-document')
                ->openUrlInNewTab(),
        ];
    }
}
