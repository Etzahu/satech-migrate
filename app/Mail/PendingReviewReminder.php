<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Recordatorio de lo que una persona tiene pendiente por revisar.
 *
 * Lo manda `purchases:remind-pending`, uno por persona y solo a quien tiene
 * algo; el contenido lo arma App\Services\PendingReviewReminderService.
 */
class PendingReviewReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array<int, array{type: string, folio: string, action: string, requester: ?string, company: ?string, days: int, url: string}>  $items
     */
    public function __construct(public User $recipient, public array $items) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->headline(),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.pending-review-reminder',
            with: [
                'companies' => collect($this->items)->groupBy('company'),
            ],
        );
    }

    /**
     * Asunto con cuántos documentos esperan, para que se lea sin abrir el correo.
     */
    public function headline(): string
    {
        $count = count($this->items);

        return $count === 1
            ? 'Compras: tienes 1 documento pendiente por revisar'
            : "Compras: tienes {$count} documentos pendientes por revisar";
    }
}
