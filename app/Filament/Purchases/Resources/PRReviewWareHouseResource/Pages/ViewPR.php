<?php

namespace App\Filament\Purchases\Resources\PRReviewWareHouseResource\Pages;


use Filament\Tables;
use Filament\Forms\Get;
use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Services\PRMediaService;
use Filament\Infolists\Infolist;
use Filament\Forms\Components\Select;
use App\Models\PurchaseRequisitionItem;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Actions\Action as ActionTable;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
                        ->requiredUnless('response', 'revision')
                        ->label('Observación'),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    $this->record->status()->transitionTo($data['response'], ['respuesta' => $data['observation']]);
                    Notification::make()
                        ->title('Respuesta enviada')
                        ->success()
                        ->send();
                    return redirect(PRReviewWareHouseResource::getUrl('index'));
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
        return $service->generateInfolist($infolist, $this->record, false);
    }
}
