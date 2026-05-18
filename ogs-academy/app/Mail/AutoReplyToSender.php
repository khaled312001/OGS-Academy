<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AutoReplyToSender extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $recipientName,
        public ?string $programTitle = null,
        public string $type = 'inquiry', // inquiry | contact
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->type === 'contact'
            ? 'شكراً لتواصلك مع أكاديمية OGS'
            : 'شكراً لاهتمامك ببرامج أكاديمية OGS';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.auto-reply',
            with: [
                'recipientName' => $this->recipientName,
                'programTitle'  => $this->programTitle,
                'type'          => $this->type,
            ],
        );
    }
}
