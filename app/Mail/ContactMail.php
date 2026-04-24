<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;

class ContactMail extends Mailable
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Новое обращение в поддержку',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.support',
            with: [
                'data' => $this->data
            ]
        );
    }

    public function attachments(): array
    {
        $files = [];

        if (!empty($this->data['attachments'])) {
            foreach ($this->data['attachments'] as $file) {
                $files[] = Attachment::fromPath($file->getRealPath())
                    ->as($file->getClientOriginalName());
            }
        }

        return $files;
    }
}
