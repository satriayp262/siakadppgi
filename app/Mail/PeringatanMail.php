<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class PeringatanMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Generate PDF dari view
        $pdf = Pdf::loadView('mail.surat_peringatan_pdf', [
            'nama' => $this->data['nama'],
            'nim' => $this->data['nim'],
            'alpha_count' => $this->data['alpha_count'],
            'no_surat' => $this->data['no_surat'], // Tambahkan nomor surat
        ]);

        return $this->subject('Surat Peringatan Kedisiplinan')
            ->view('mail.peringatanmail')
            ->attachData($pdf->output(), 'Surat-Peringatan.pdf', [
                'mime' => 'application/pdf',
            ])
            ->with([
                'nama' => $this->data['nama'],
                'nim' => $this->data['nim'],
                'alpha_count' => $this->data['alpha_count'],
                'no_surat' => $this->data['no_surat'], // Sertakan nomor surat
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Surat Peringatan Kedisiplinan',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.peringatanmail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
