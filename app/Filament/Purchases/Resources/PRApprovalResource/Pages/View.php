<?php

namespace App\Filament\Purchases\Resources\PRApprovalResource\Pages;

use App\Filament\Purchases\Resources\PRApprovalResource;
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
    protected static string $resource = PRApprovalResource::class;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->visible(fn() => $this->record->status()->canBe('aprobado por gerencia') || $this->record->status()->canBe('devuelto por gerencia') || $this->record->status()->canBe('cancelado por gerencia'))
                ->color('success')
                ->form([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'aprobado por gerencia' => 'Aprobar',
                            'devuelto por gerencia' => 'Devolver',
                            'cancelado por gerencia' => 'Rechazar',
                        ])
                        ->default('aprobado por gerencia')
                        ->required()
                        ->live(),
                    Textarea::make('observation')
                        ->required(fn(Get $get): bool => $get('response') !== 'aprobado por revisor')
                        ->label('Observación'),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    $this->record->status()->transitionTo($data['response'], ['respuesta' => $data['observation']]);
                    Notification::make()
                        ->title('Respuesta enviada')
                        ->success()
                        ->send();
                    return redirect()->route('filament.compras.resources.requisiciones-revisar.index');
                }),
            Action::make('Ver pdf')
                ->color('danger')
                ->icon('heroicon-m-document')
                // ->url(fn(): string => route('compras.requisiciones.pdf', ['id' => $this->record->id]))
                // ->url(fn(): string => route('filament.compras.resources.mis-requisiciones.pdf', ['record' => $this->record->id]))
                ->openUrlInNewTab()
        ];
    }
    public function infolist(Infolist $infolist): Infolist
    {
        $service = new PRMediaService();
        return $service->generateInfolist($infolist, $this->record);
    }
}
