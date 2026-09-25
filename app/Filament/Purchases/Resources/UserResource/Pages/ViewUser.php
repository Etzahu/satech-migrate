<?php

namespace App\Filament\Purchases\Resources\UserResource\Pages;

use App\Filament\Purchases\Resources\UserResource;
use App\Mail\UserInvitation;
use App\Services\GuideCatalog;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Mail;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->invitationAction(),
            EditAction::make(),
        ];
    }

    /**
     * Correo de bienvenida con las guías de uso adjuntas.
     *
     * Las guías llegan premarcadas según los roles del usuario —la misma
     * división por tipo que usa la página «Guías de uso»—, pero quien envía
     * decide: puede quitar las que sobran o agregar las que hagan falta antes
     * de mandar el correo.
     */
    protected function invitationAction(): Action
    {
        $catalog = app(GuideCatalog::class);

        return Action::make('enviarInvitacion')
            ->label('Enviar invitación')
            ->icon('heroicon-o-envelope')
            ->color('success')
            ->button()
            // A un usuario dado de baja no se le invita a entrar.
            ->visible(fn (): bool => (bool) $this->record->active)
            ->modalHeading('Enviar invitación de bienvenida')
            ->modalDescription(fn (): string => "El correo se enviará a {$this->record->email} con las guías seleccionadas adjuntas en PDF.")
            ->modalWidth(Width::TwoExtraLarge)
            ->modalSubmitActionLabel('Enviar correo')
            ->slideOver()
            ->schema([
                CheckboxList::make('guides')
                    ->label('Guías a adjuntar')
                    ->helperText('Vienen marcadas las que corresponden a los roles del usuario. Solo se listan las guías que ya tienen PDF publicado.')
                    ->options($catalog->pdfOptions())
                    ->descriptions(collect($catalog->withPdf())
                        ->mapWithKeys(fn (array $guide) => [$guide['slug'] => $guide['description']])
                        ->all())
                    ->default(fn (): array => $catalog->suggestedFor($this->record))
                    ->bulkToggleable()
                    ->columns(1)
                    ->required()
                    ->validationMessages([
                        'required' => 'Selecciona al menos una guía para adjuntar.',
                    ]),
                Textarea::make('note')
                    ->label('Mensaje adicional')
                    ->placeholder('Opcional: un párrafo de contexto para quien recibe la invitación.')
                    ->rows(3)
                    ->maxLength(1000),
            ])
            ->action(function (array $data): void {
                $record = $this->record;

                try {
                    Mail::to($record->email)->send(
                        new UserInvitation($record, $data['guides'], $data['note'] ?? null)
                    );

                    Notification::make()
                        ->title('Invitación enviada')
                        ->body("Se enviaron {$this->guideCount($data['guides'])} a {$record->email}.")
                        ->success()
                        ->send();
                } catch (\Throwable $e) {
                    logger()->error('Error al enviar la invitación de bienvenida: '.$e->getMessage(), [
                        'user_id' => $record->getKey(),
                        'guides' => $data['guides'],
                        'sender_id' => auth()->id(),
                    ]);

                    Notification::make()
                        ->title('No se pudo enviar la invitación')
                        ->body('Revisa el correo del usuario y vuelve a intentar. El detalle quedó en la bitácora del sistema.')
                        ->danger()
                        ->persistent()
                        ->send();
                }
            });
    }

    /**
     * @param  array<int, string>  $guides
     */
    protected function guideCount(array $guides): string
    {
        $total = count($guides);

        return $total === 1 ? '1 guía' : "{$total} guías";
    }
}
