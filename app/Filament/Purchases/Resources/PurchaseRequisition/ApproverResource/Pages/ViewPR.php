<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\ApproverResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\ApproverResource;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewPR extends ViewRecord
{
    protected static string $resource = ApproverResource::class;

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->visible(fn () => $this->record->status()->canBe('aprobado por gerencia') || $this->record->status()->canBe('devuelto por gerencia') || $this->record->status()->canBe('cancelado por gerencia'))
                ->color('success')
                ->schema([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'aprobado por gerencia' => 'Aprobar',
                            'devuelto por gerencia' => 'Devolver',
                            'cancelado por gerencia' => 'Cancelar',
                        ])
                        ->default('aprobado por gerencia')
                        ->required(),
                    Textarea::make('observation')
                        ->requiredUnless('response', 'aprobado por gerencia')
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

                    return redirect(ApproverResource::getUrl('index'));
                }),
            Action::make('Ver pdf')
                ->color('danger')
                ->url(route('requisition.pdf', ['id' => $this->record->id]))
                ->icon('heroicon-m-document')
                ->openUrlInNewTab(),
        ];
    }
}
