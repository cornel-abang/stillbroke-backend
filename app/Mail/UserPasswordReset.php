<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class UserPasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private string $user_name)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Stillbroke - Password Change',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.password-changed',
            with: ['user_name' => $this->user_name]
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
