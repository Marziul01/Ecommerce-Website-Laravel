<?php

namespace App\Mail;


use App\Models\Order;
use App\Models\SiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;

class OrderEmail extends Mailable
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
//    public function envelope(): Envelope
//    {
//        return new Envelope(
//            subject: 'Your order has been placed !!',
//            from: new Address('marziulhaque08@gmail.com' , 'Evara'),
//        );
//    }
//
//    /**
//     * Get the message content definition.
//     */
//    public function content(): Content
//    {
//        return new Content(
//            view: 'email.order',
//        );
//    }
    public function build()
    {
        $siteSetting = SiteSetting::where('id', 1)->first();
        return $this->subject('Your order has been placed !!')
            ->from(
                $siteSetting?->email ?? config('mail.from.address'),
                $siteSetting?->title ?? config('mail.from.name')
                )
            ->view('email.order')
            ->attachData($this->orderData['pdf'], 'Invoice_' . $this->orderData['id'] . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
//    public function attachments(): array
//    {
//        return [
//            Attachment::fromData(fn () => $this->orderData['pdf'], 'Invoice_'.$this->orderData['id'].'.pdf')
//                ->withMime('application/pdf'),
//        ];
//    }

}
