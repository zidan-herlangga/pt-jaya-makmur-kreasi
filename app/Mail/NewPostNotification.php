<?php

namespace App\Mail;

use App\Models\NewsletterSubscriber;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewPostNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Post $post,
        public NewsletterSubscriber $subscriber,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Berita Baru: ' . $this->post->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.new-post-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
