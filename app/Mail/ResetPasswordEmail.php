<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private string $client_name)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Stillbroke - Reset Your Password',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.password-reset',
            with: ['name' => $this->client_name]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
