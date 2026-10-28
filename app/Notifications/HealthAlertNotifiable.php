<?php

namespace App\Notifications;

use App\Services\FlowHealthService;
use Spatie\Health\Notifications\Notifiable;

/**
 * Destinatario de las fallas que detecta la página de Salud (spatie/laravel-health).
 *
 * Le llegan a las mismas personas que el aviso de `purchases:flow-health`, en
 * lugar de a la dirección fija de `health.notifications.mail.to`, para que
 * haya un solo lugar donde decidir quién recibe los avisos de operación.
 */
class HealthAlertNotifiable extends Notifiable
{
    /**
     * @return array<int, string>
     */
    public function routeNotificationForMail(): array
    {
        return app(FlowHealthService::class)->alertRecipients();
    }
}
