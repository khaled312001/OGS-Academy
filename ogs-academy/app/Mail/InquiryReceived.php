<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Inquiry $inquiry) {}

    public function envelope(): Envelope
    {
        $label = $this->inquiry->company ?: $this->inquiry->full_name;
        $subject = '[طلب برنامج] ' . $label
                 . ($this->inquiry->program ? ' — ' . $this->inquiry->program->title_ar : '');

        return new Envelope(
            subject: $subject,
            replyTo: [$this->inquiry->email => $this->inquiry->full_name],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.inquiry-received',
            with: ['inquiry' => $this->inquiry],
        );
    }
}
