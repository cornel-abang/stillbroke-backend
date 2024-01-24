<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\VerificationCode;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private VerificationCode $verifyCode)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Stillbroke - Verify Your Email',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.verification',
            with: ['verifyCode' => $this->verifyCode->toArray()]
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
