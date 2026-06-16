<?php

namespace App\Filament\Purchases\Resources\PurchaseProviderResource\Pages;

use App\Filament\Purchases\Resources\PurchaseProviderResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewPurchaseProvider extends ViewRecord
{
    protected static string $resource = PurchaseProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Action::make('responder')
                ->visible(($this->record->status()->canBe('aprobado') || $this->record->status()->canBe('rechazado')))
                ->requiresConfirmation()
                ->schema([
                    Select::make('response')
                        ->label('Respuesta')
                        ->options([
                            'aprobado' => 'Aprobar',
                            'rechazado' => 'Rechazar',
                        ])
                        ->default('aprobado')
                        ->required(),
                    Textarea::make('observation')
                        ->requiredUnless('response', 'aprobado')
                        ->validationMessages([
                            'required_unless' => 'El campo :attribute es obligatorio.',
                        ])
                        ->label('Observación'),
                ])
                ->action(function (array $data): void {
                    $this->record->status()->transitionTo($data['response'], ['respuesta' => $data['observation']]);
                    Notification::make()
                        ->title('Respuesta guardada')
                        ->success()
                        ->send();
                })
                ->color('success'),
        ];
    }
}
