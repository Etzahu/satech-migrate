<?php

namespace App\Services;

use Tapp\FilamentMailLog\Models\MailLog;

/**
 * Borra de la bitácora de correos lo que pasa de cierta antigüedad.
 *
 * Lo usan la limpieza de cada domingo (routes/console.php) y el botón
 * "Limpiar antiguos" de la página Correos enviados.
 */
class MailLogPruner
{
    /**
     * Borra los correos enviados hace más de `$days` días y dice cuántos fueron.
     */
    public function prune(int $days): int
    {
        return MailLog::query()
            ->where('created_at', '<', now()->subDays($days))
            ->delete();
    }
}
