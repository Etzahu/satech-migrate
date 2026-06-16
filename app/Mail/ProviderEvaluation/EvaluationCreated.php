<?php

namespace App\Mail\ProviderEvaluation;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EvaluationCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva evaluación de proveedor — '.$this->data['folio'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.provider-evaluation.created',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
