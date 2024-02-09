<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminUserDetails extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private array $info)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Stillbroke - Admin User Details',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.admin-details',
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
