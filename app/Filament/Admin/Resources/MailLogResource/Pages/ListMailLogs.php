<?php

namespace App\Filament\Admin\Resources\MailLogResource\Pages;

use App\Filament\Admin\Resources\MailLogResource;
use App\Services\MailLogPruner;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Tapp\FilamentMailLog\Models\MailLog;
use Tapp\FilamentMailLog\Resources\MailLogResource\Pages\ListMailLogs as BaseListMailLogs;

class ListMailLogs extends BaseListMailLogs
{
    protected static string $resource = MailLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('prune')
                ->label('Limpiar antiguos')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->visible(fn (): bool => auth()->user()?->can('deleteAny', MailLog::class) ?? false)
                ->modalHeading('Limpiar la bitácora de correos')
                ->modalDescription('Los correos borrados no se pueden recuperar. La limpieza automática de cada domingo sigue igual.')
                ->modalSubmitActionLabel('Borrar')
                ->schema([
                    TextInput::make('days')
                        ->label('Borrar los correos enviados hace más de')
                        ->suffix('días')
                        ->integer()
                        ->minValue(1)
                        ->required()
                        ->default(config('filament-maillog.keep_for_days')),
                ])
                ->action(function (array $data, MailLogPruner $pruner): void {
                    $deleted = $pruner->prune((int) $data['days']);

                    Notification::make()
                        ->title(match ($deleted) {
                            0 => 'No había correos tan antiguos',
                            1 => 'Se borró 1 correo',
                            default => "Se borraron {$deleted} correos",
                        })
                        ->success()
                        ->send();
                }),
        ];
    }
}
