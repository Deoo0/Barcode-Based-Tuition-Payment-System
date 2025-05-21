<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Mail\Mailables\Attachment;

class PaymentReceiptMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $student;
    public $payment;
    protected $pdfContent;

    /**
     * Create a new message instance.
     */
    public function __construct(object $student,object $payment, ?string $pdfContent = null)
    {
        $this->student = $student;
        $this->payment = $payment;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Receipt - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.receipt',
            with: [
                'student' => $this->student,
                'payment' => $this->payment,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
{
    if ($this->pdfContent) {
        return [
            Attachment::fromData(
                fn () => $this->pdfContent,
                'receipt.pdf',
                ['mime' => 'application/pdf']
            ),
        ];
    }

    $pdf = Pdf::loadView('receipt', [
        'student' => $this->student,
        'payment' => $this->payment,
    ]);

    return [
        Attachment::fromData(
            fn () => $pdf->output(),
            'receipt.pdf',
            ['mime' => 'application/pdf']
        ),
    ];
}

}
