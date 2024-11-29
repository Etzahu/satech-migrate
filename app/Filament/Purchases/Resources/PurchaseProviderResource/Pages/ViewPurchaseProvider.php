<?php

namespace App\Filament\Purchases\Resources\PurchaseProviderResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Purchases\Resources\PurchaseProviderResource;

class ViewPurchaseProvider extends ViewRecord
{
    protected static string $resource = PurchaseProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('responder')
                ->visible(($this->record->status()->canBe('aprobado') || $this->record->status()->canBe('rechazado')) && auth()->user()->hasRole('administrador_compras') )
                ->form([
                    Select::make('request')
                        ->label('Respuesta')
                        ->options([
                            'aprobado' => 'Aprobar',
                            'rechazado' => 'Rechazar',
                        ])
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $this->record->status()->transitionTo($data['request']);
                    Notification::make()
                    ->title('Respuesta guardada')
                    ->success()
                    ->send();
                })
                ->color('success')
        ];
    }
}
