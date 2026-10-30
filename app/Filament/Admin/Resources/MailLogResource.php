<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MailLogResource\Pages\ListMailLogs;
use Tapp\FilamentMailLog\Resources\MailLogResource as BaseMailLogResource;

/**
 * La bitácora de tapp/filament-maillog con el botón "Limpiar antiguos".
 *
 * La registra el plugin desde config/filament-maillog.php. Vive fuera de
 * app/Filament/Resources para que el panel admin no la descubra además.
 */
class MailLogResource extends BaseMailLogResource
{
    public static function getPages(): array
    {
        return [
            'index' => ListMailLogs::route('/'),
        ];
    }
}
