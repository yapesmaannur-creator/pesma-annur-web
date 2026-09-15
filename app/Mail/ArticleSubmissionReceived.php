<?php

namespace App\Mail;

use App\Models\ArticleSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ArticleSubmissionReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;

    public function __construct(ArticleSubmission $submission)
    {
        $this->submission = $submission;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address(config('mail.from.address') ?? 'admin@pesan.com', 'Tim Redaksi Pesantren Mahasiswa An-Nur'),
            subject: 'Terima Kasih atas Kiriman Tulisan Anda',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.submissions.received',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
