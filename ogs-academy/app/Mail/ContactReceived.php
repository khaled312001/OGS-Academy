<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $message) {}

    public function envelope(): Envelope
    {
        $safeName = trim(preg_replace('/[()<>@,;:\\\\".\[\]]/u', ' ', $this->message->full_name));

        return new Envelope(
            subject: '[رسالة جديدة] ' . ($this->message->subject ?: $this->message->full_name),
            replyTo: [$this->message->email => $safeName ?: $this->message->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-received',
            with: ['message' => $this->message],
        );
    }
}
