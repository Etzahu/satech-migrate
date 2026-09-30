<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Aviso diario de los niveles del flujo que nadie puede responder.
 *
 * Lo manda `purchases:flow-health` solo cuando encuentra algo; el contenido lo
 * arma App\Services\FlowHealthService.
 */
class FlowHealthReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array{vacant_roles: array<int, array<string, mixed>>, inactive: array<int, array<string, mixed>>}  $report
     */
    public function __construct(public array $report) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->headline(),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.flow-health-report',
            with: [
                'idleDays' => (int) config('purchases.flow_alerts.idle_days', 30),
            ],
        );
    }

    /**
     * Asunto con el tamaño del problema, para que se lea sin abrir el correo.
     */
    public function headline(): string
    {
        $parts = [];

        $roles = count($this->report['vacant_roles']);

        if ($roles > 0) {
            $parts[] = $roles === 1 ? '1 rol sin titular activo' : "{$roles} roles sin titular activo";
        }

        $items = collect($this->report['inactive'])->sum(fn (array $group) => count($group['items']));

        if ($items > 0) {
            $parts[] = $items === 1
                ? '1 pendiente que espera a una cuenta inactiva'
                : "{$items} pendientes que esperan a una cuenta inactiva";
        }

        return 'Flujo de compras: '.implode(' · ', $parts);
    }
}
