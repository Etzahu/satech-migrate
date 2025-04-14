<?php

namespace App\Filament\Purchases\Resources\ProjectPurchaseResource\Pages;

use App\Filament\Purchases\Resources\ProjectPurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;

class EditProjectPurchase extends EditRecord
{
    protected static string $resource = ProjectPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
        ];
    }
    protected function getFormActions(): array
    {
        if ($this->record->status == 'pendiente') {
            return  [
                Action::make('Capturar respuesta')
                    ->modalHeading('Enviar respuesta')
                    ->color('success')

                    ->form([
                        Select::make('response')
                            ->label('Respuesta')
                            ->options([
                                'activo' => 'Aprobar',
                                'rechazado' => 'Rechazar',
                            ])
                            ->default('activo')
                            ->required(),
                    ])
                    ->requiresConfirmation()
                    ->action(function (array $data) {
                        $this->form->getState();
                        $dataUpdate = $this->form->getState();
                        $this->record->status()->transitionTo($data['response']);
                        $this->record->code = $dataUpdate['code'];
                        $this->record->name = $dataUpdate['name'];
                        $this->record->registered_user_id = auth()->user()->id;
                        $this->record->save();
                        Notification::make()
                            ->title('Respuesta enviada')
                            ->success()
                            ->send();
                    }),
            ];
        } elseif ($this->record->status == 'activo') {
            return [
                $this->getSaveFormAction(),
            ];
        } else {
            return [];
        }
    }
}
