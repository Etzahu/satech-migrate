<?php

namespace App\Filament\Purchases\Actions;

use App\Enums\ReviewLevel;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\User;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Throwable;

/**
 * Responde en lote lo seleccionado en una bandeja.
 *
 * Es el mismo "Capturar respuesta" de la vista aplicado a cada registro por
 * separado: cada uno pasa por la máquina de estados, deja su historial y manda
 * su correo, como si se respondiera uno por uno. Lo que ya no espera en este
 * nivel o no le toca al usuario se omite, y un registro que falla no detiene a
 * los demás.
 *
 * Solo la ve quien, además de poder responder el nivel, tiene `super_admin`.
 * No basta con ese rol: super_admin trae todos los permisos, pero la regla de
 * cada nivel se revisa con el rol operativo o la cadena, igual que en la vista.
 * Oculta, Filament tampoco deja ejecutarla.
 */
class RespondInBulkAction extends BulkAction
{
    /**
     * Cada registro manda su correo dentro de la misma petición; más de esto
     * se acerca al tiempo límite del servidor.
     */
    public const MAX_RECORDS = 20;

    public const REQUIRED_ROLE = 'super_admin';

    protected ReviewLevel $level;

    public static function getDefaultName(): ?string
    {
        return 'responder_seleccionadas';
    }

    public function level(ReviewLevel $level): static
    {
        $this->level = $level;

        return $this;
    }

    /**
     * ¿El usuario puede responder en lote este nivel?
     */
    public function isAllowedFor(?User $user): bool
    {
        return (bool) $user?->hasRole(self::REQUIRED_ROLE)
            && $this->level->isAvailableTo($user);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('Responder seleccionadas')
            ->icon('heroicon-m-check-badge')
            ->color('success')
            ->visible(fn (): bool => $this->isAllowedFor(auth()->user()))
            ->modalHeading('Responder seleccionadas')
            ->modalDescription('La respuesta y la observación se aplican a cada registro seleccionado, con su historial y su correo, igual que al responderlos uno por uno.')
            ->schema(fn (): array => [
                Select::make('response')
                    ->label('Respuesta')
                    ->options($this->level->responses())
                    ->default($this->level->approval())
                    ->required(),
                Textarea::make('observation')
                    ->requiredUnless('response', $this->level->approval())
                    ->validationMessages([
                        'required_unless' => 'El campo :attribute es obligatorio.',
                    ])
                    ->label('Observación'),
            ])
            ->requiresConfirmation()
            ->deselectRecordsAfterCompletion()
            ->action(fn (Collection $records, array $data) => $this->respondTo($records, $data['response'], $data['observation'] ?? null));
    }

    /**
     * @param  Collection<int, PurchaseOrder|PurchaseRequisition>  $records
     */
    protected function respondTo(Collection $records, string $response, ?string $observation): void
    {
        $user = auth()->user();
        $applied = [];
        $skipped = [];
        $failed = [];

        foreach ($records as $record) {
            if (! $this->level->canRespond($record, $user)) {
                $skipped[] = $record->folio;

                continue;
            }

            try {
                $this->level->respond($record, $response, $observation);
                $applied[] = $record->folio;
            } catch (Throwable $exception) {
                report($exception);
                $failed[] = $record->folio;
            }
        }

        $this->notifyResult($records->count(), $applied, $skipped, $failed);
    }

    /**
     * @param  array<int, string>  $applied
     * @param  array<int, string>  $skipped
     * @param  array<int, string>  $failed
     */
    protected function notifyResult(int $total, array $applied, array $skipped, array $failed): void
    {
        $lines = [];

        if ($skipped !== []) {
            $lines[] = 'Omitidas porque ya no esperan en este nivel o no te toca responderlas: '.e(implode(', ', $skipped)).'.';
        }

        if ($failed !== []) {
            // La máquina de estados guarda la respuesta antes de mandar el
            // correo, así que un error puede dejarla registrada a medias.
            $lines[] = 'Con error: '.e(implode(', ', $failed)).'. Revisa su historial antes de volver a intentarlo.';
        }

        $notification = Notification::make()
            ->title(match (count($applied)) {
                0 => 'No se envió ninguna respuesta',
                $total => $total === 1 ? 'Respuesta enviada' : "Respuesta enviada a las {$total} seleccionadas",
                default => 'Respuesta enviada a '.count($applied)." de {$total} seleccionadas",
            })
            ->body($lines === [] ? null : implode('<br>', $lines));

        match (true) {
            $applied === [] => $notification->danger()->persistent(),
            $lines === [] => $notification->success(),
            default => $notification->warning()->persistent(),
        };

        $notification->send();
    }
}
