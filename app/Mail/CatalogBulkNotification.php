<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

/**
 * Un solo aviso a Compras con todos los productos/servicios que un solicitante
 * dio de alta desde Excel, en lugar de un correo por cada uno.
 */
class CatalogBulkNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  Collection<int, Product>  $products  Con company, requester y unit cargados.
     */
    public function __construct(public Collection $products) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Alta de productos/servicios ({$this->products->count()})",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.catalog-bulk-notification',
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
