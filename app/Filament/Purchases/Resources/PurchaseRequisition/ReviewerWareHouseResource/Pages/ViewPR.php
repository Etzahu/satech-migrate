<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerWareHouseResource\Pages;



use Filament\Actions\Action;
use Filament\Infolists\Infolist;
use App\Services\PRInfolistService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerWareHouseResource;



class ViewPR extends ViewRecord
{
    protected static string $resource = ReviewerWareHouseResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Action::make('Capturar respuesta')
                ->modalHeading('Enviar respuesta')
                ->visible(fn() => $this->record->status()->canBe('revisión') || $this->record->status()->canBe('devuelto por almacén'))
                ->color('success')
                ->form([
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
                ->openUrlInNewTab()
        ];
    }
}
