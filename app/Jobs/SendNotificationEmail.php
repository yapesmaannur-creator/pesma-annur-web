<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
// use App\Mail\ContactNotification;

class SendNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $validatedData;

    public function __construct(array $validatedData)
    {
        $this->validatedData = $validatedData;
    }

    public function handle(): void
    {
        // Un-comment when Mailable exists
        // Mail::to('admin@domainkami.com')->send(new ContactNotification($this->validatedData));
    }
}
