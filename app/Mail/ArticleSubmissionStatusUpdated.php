<?php

namespace App\Mail;

use App\Models\ArticleSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ArticleSubmissionStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;
    public $postStatus;
    public $postLink;

    public function __construct(ArticleSubmission $submission, $postStatus = null, $postLink = null)
    {
        $this->submission = $submission;
        $this->postStatus = $postStatus;
        $this->postLink = $postLink;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address(config('mail.from.address') ?? 'admin@pesan.com', 'Tim Redaksi Pesantren Mahasiswa An-Nur'),
            subject: 'Pemberitahuan Status Kiriman Tulisan Anda',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.submissions.status_updated',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
