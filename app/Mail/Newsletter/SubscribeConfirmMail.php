<?php

namespace App\Mail\Newsletter;

use App\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscribeConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriber;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(NewsletterSubscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.newsletter.confirm')
            ->subject('Your Subscription has been Confirmed');
    }
}
