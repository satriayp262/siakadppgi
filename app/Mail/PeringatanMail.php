<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

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

    }public function build()
    {
        return $this->view('emails.peringatan')
            ->with([
                'nama' => $this->data['nama'], // Kirim data ke view
                'nim' => $this->data['nim'],
                'alpha_count' => $this->data['alpha_count'],
            ])
            ->attach(public_path('img/kop_surat.jpg'), [
                'as' => 'kop_surat.jpg',
                'mime' => 'image/jpg'
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
