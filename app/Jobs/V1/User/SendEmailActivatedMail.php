<?php

namespace App\Jobs\V1\User;

use App\Mail\V1\User\EmailActivatedMail;
use App\Mail\V1\User\EmailActivationMail;
use App\Models\EmailActivationToken;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEmailActivatedMail implements ShouldQueue
{
    use Queueable;

    private User $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new EmailActivatedMail($this->user));
    }
}
