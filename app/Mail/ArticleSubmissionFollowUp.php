<?php

namespace App\Mail;

use App\Models\ArticleSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ArticleSubmissionFollowUp extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;
    public $messageStr;

    public function __construct(ArticleSubmission $submission, string $messageStr)
    {
        $this->submission = $submission;
        $this->messageStr = $messageStr;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address(config('mail.from.address') ?? 'admin@pesan.com', 'Tim Redaksi Pesantren Mahasiswa An-Nur'),
            subject: 'Pesan Lanjutan: Mengenai Tulisan Anda "' . $this->submission->title . '"',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.submissions.follow_up',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
