<?php

namespace App\Mail\PurchaseRequisition;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\PurchaseRequisition;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Barryvdh\DomPDF\Facade\Pdf;

class Notification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public $data) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.purchase-requisition.notification',
        );
    }

    // public function attachments(): array
    // {
    //     // Se produce un error por los acentos
    //     $namePdf = "{$this->data['folio']}.pdf";
    //     $rq = PurchaseRequisition::with(['items', 'approvalChain', 'project', 'items.product', 'items.product.unit', 'company'])->findOrFail($this->data['id']);
    //     $pdf = Pdf::loadView('pdf.purchase-requisition', compact('rq'))->setPaper('a4', 'landscape');
    //     // Configurar DomPDF para usar UTF-8
    //     $pdf->setOption('defaultFont', 'Arial'); // Usa una fuente compatible con UTF-8
    //     $pdf->setOption('isHtml5ParserEnabled', true);
    //     $pdf->setOption('isPhpEnabled', true);
    //     $pdf->setOption('isRemoteEnabled', true);
    //     // $pdf->save($namePdf, 'temp-email-pdf');
    //     // return [
    //     //     Attachment::fromStorageDisk('temp-email-pdf', $namePdf)
    //     // ];
    //     return [
    //         Attachment::fromData(fn () => $pdf->output(), 'Report.pdf')
    //                 ->withMime('application/pdf'),
    //     ];
    // }
}
