<?php

namespace App\Mail;

use App\Models\ArticleSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ArticleSubmissionLive extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;
    public $postLink;

    public function __construct(ArticleSubmission $submission, string $postLink)
    {
        $this->submission = $submission;
        $this->postLink = $postLink;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address(config('mail.from.address') ?? 'admin@pesan.com', 'Tim Redaksi Pesantren Mahasiswa An-Nur'),
            subject: 'SELAMAT! Artikel Anda Kini Telah Tayang (' . $this->submission->title . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.submissions.live',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
