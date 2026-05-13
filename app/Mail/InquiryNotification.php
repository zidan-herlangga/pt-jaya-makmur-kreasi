<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Inquiry $inquiry) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pertanyaan Baru: ' . $this->inquiry->sender_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.inquiry-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
