<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerResource\Pages;

use Filament\Forms\Get;
use Filament\Actions\Action;
use App\Services\PRMediaService;
use Filament\Infolists\Infolist;
use App\Services\PRInfolistService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerResource;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class View extends ViewRecord
{
    use InteractsWithInfolists;
    use InteractsWithRecord;
    protected static string $resource = ReviewerResource::class;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->visible(fn() => $this->record->status()->canBe('aprobado por revisor') || $this->record->status()->canBe('devuelto por revisor') || $this->record->status()->canBe('cancelado por revisor'))
                ->color('success')
                ->form([
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
                ->icon('heroicon-m-document')
                ->openUrlInNewTab()
        ];
    }
    public function infolist(Infolist $infolist): Infolist
    {
        $service = new PRInfolistService();
        return $service->build($infolist, $this->record);
    }
}
