<?php

namespace App\Filament\Purchases\Resources\PRReviewWareHouseResource\Pages;


use Filament\Actions\Action;
use App\Services\PRMediaService;
use Filament\Infolists\Infolist;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Filament\Purchases\Resources\PRReviewWareHouseResource;


class ViewPR extends ViewRecord
{
    use InteractsWithInfolists;
    use InteractsWithRecord;
    protected static string $resource = PRReviewWareHouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Enviar revisión')

                // ->visible(fn() => $this->record->status()->canBe('revisión'))
                ->color('success')
                ->form([
                    Textarea::make('observation')
                        ->label('Observación'),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    $this->record->status()->transitionTo('revisión', ['respuesta' => $data['observation']]);
                    Notification::make()
                    ->title('Respuesta enviada')
                    ->success()
                    ->send();
                    return redirect()->route('filament.compras.resources.requisiciones.revisar.almacen.index');
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
