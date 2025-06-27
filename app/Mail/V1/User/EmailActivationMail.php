<?php

namespace App\Mail\V1\User;

use App\Models\EmailActivationToken;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    private array $user;

    private array $emailActivationToken;

    /**
     * Create a new message instance.
     */
    public function __construct(array $user, array $emailActivationToken)
    {
        $this->user = $user;
        $this->emailActivationToken = $emailActivationToken;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(subject: '【'.config('app.name').'】新規会員登録のご案内');
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(markdown: 'mail.user.email_activation_mail', with: [
            'user' => $this->user,
            'url' => config('app.frontend_url').'user/email_activate/'.$this->emailActivationToken['token'],
        ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
