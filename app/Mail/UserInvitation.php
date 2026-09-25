<?php

namespace App\Mail;

use App\Models\User;
use App\Services\GuideCatalog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Invitación de bienvenida al sistema con las guías de uso adjuntas.
 *
 * Se dispara a mano desde la ficha del usuario, no desde un flujo: es el correo
 * con el que se le da entrada a alguien recién dado de alta o a quien cambió de
 * rol y necesita el material de su nueva función.
 */
class UserInvitation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  User  $recipient  Usuario al que se invita.
     * @param  array<int, string>  $guides  Slugs de las guías a adjuntar.
     * @param  string|null  $note  Mensaje que escribe quien envía la invitación.
     */
    public function __construct(
        public User $recipient,
        public array $guides = [],
        public ?string $note = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bienvenido a SA-TECH · Sistema de Compras',
        );
    }

    public function content(): Content
    {
        // `recipient` y `note` llegan solas a la vista por ser propiedades
        // públicas. Las guías resueltas van con otro nombre a propósito: una
        // propiedad pública pisa lo que se pase en `with`, y `$guides` son los
        // slugs, no las guías completas que necesita el cuerpo del correo.
        return new Content(
            view: 'email.user-invitation',
            with: [
                'attachedGuides' => $this->resolvedGuides(),
            ],
        );
    }

    /**
     * Guías del correo, ya resueltas contra el catálogo.
     *
     * Solo sobreviven las que tienen PDF en disco, de modo que la lista del
     * cuerpo y los archivos adjuntos siempre coinciden.
     *
     * @return array<int, array<string, mixed>>
     */
    public function resolvedGuides(): array
    {
        $catalog = app(GuideCatalog::class);
        $resolved = [];

        foreach ($this->guides as $slug) {
            $guide = $catalog->find($slug);

            if ($guide && $catalog->pdfPath($slug)) {
                $resolved[] = $guide;
            }
        }

        return $resolved;
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $catalog = app(GuideCatalog::class);

        return array_map(
            fn (array $guide) => Attachment::fromPath($catalog->pdfPath($guide['slug']))
                ->as($guide['pdf'])
                ->withMime('application/pdf'),
            $this->resolvedGuides(),
        );
    }
}
