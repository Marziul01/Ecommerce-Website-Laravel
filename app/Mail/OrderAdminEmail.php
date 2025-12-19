<?php

namespace App\Mail;

use App\Models\SiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderAdminEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $orderData;

    /**
     * Create a new message instance.
     */
    public function __construct($orderData)
    {
        $this->orderData = $orderData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $siteSetting = SiteSetting::where('id', 1)->first();
        return new Envelope(
        subject: 'New Order has been placed !!',
        from: new Address(
            $siteSetting?->email ?? config('mail.from.address'),
            $siteSetting?->title ?? config('mail.from.name')
        ),
    );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.orderAdmin',
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
