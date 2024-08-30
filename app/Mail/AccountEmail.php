<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailMessage;
    public $subject;
    public $fullName;
    public $link;
    public $linkContent;
    public $view;
    public $link2;
    public $linkContent2;

    /**
     * Create a new message instance.
     */
    public function __construct($message, $subject, $fullName, $view = 'mail-template.register-mail', $link = 'http://127.0.0.1:8000/', $linkContent = 'Khám phá ngay', $link2 = null, $linkContent2 = null)
    {
        if($link == 'http://127.0.0.1:8000/') {
            $link = route('home');
        }
        if($link2 == null) {
            $link2 = route('home');
        }
        if($linkContent2 == null) {
            $linkContent2 = 'Khám phá ngay';
        }
        $this->mailMessage = $message;
        $this->subject = $subject;
        $this->fullName = $fullName;
        $this->link = $link;
        $this->linkContent = $linkContent;
        $this->view = $view;
        $this->link2 = $link2;
        $this->linkContent2 = $linkContent2;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: $this->view,
        );
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
