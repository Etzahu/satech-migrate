<?php

namespace App\Filament\Purchases\Resources\RequestIncorporation\PurchaseProviderResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Purchases\Resources\RequestIncorporation\PurchaseProviderResource;

class ViewPurchaseProvider extends ViewRecord
{
    protected static string $resource = PurchaseProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible($this->record->status == 'aprobado'),
            Actions\Action::make('Solicitar alta')
                ->visible($this->record->status()->canBe('revisión'))
                ->requiresConfirmation()
                ->action(function (array $data): void {
                    $this->record->status()->transitionTo('revisión');
                    Notification::make()
                        ->title('Se envió a revisión')
                        ->success()
                        ->send();
                })
                ->color('success')
        ];
    }
}
