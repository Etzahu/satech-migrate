<?php

namespace App\Filament\Purchases\Resources\PRApprovalDGResource\Pages;

use App\Filament\Purchases\Resources\PRApprovalDGResource;

use Filament\Forms\Get;
use Filament\Actions\Action;
use App\Services\PRMediaService;
use Filament\Infolists\Infolist;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\ViewRecord;

class View extends ViewRecord
{
    use InteractsWithInfolists;
    use InteractsWithRecord;
    protected static string $resource = PRApprovalDGResource::class;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

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
                        ->requiredUnless('response','aprobado por DG')
                        ->label('Observación'),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    $this->record->status()->transitionTo($data['response'], ['respuesta' => $data['observation']]);
                    Notification::make()
                        ->title('Respuesta enviada')
                        ->success()
                        ->send();
                    return redirect(PRApprovalDGResource::getUrl('index'));
                }),
            Action::make('Ver pdf')
                ->color('danger')
                ->icon('heroicon-m-document')
                ->openUrlInNewTab()
        ];
    }
    public function infolist(Infolist $infolist): Infolist
    {
        $service = new PRMediaService();
        return $service->generateInfolist($infolist, $this->record);
    }
}
