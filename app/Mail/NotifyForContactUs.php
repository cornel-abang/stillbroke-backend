<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class NotifyForContactUs extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private array $info)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Stillbroke - User Contact',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.contact-us',
            with: ['info' => $this->info]
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
