<?php

namespace App\Mail\Newsletter;

use App\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscribeConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Subscriber object
     *
     * @var object
     */
    public $subscriber;

    /**
     * Set level status (error, success)
     *
     * @var string
     */
    public $level = 'success';

    /**
     * Greeting text
     *
     * @var string
     */
    public $greeting;

    /**
     * Intro lines
     *
     * @var array
     */
    public $introLines;

    /**
     * Outro lines
     *
     * @var array
     */
    public $outroLines;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(NewsletterSubscriber $subscriber)
    {
        $this->subscriber = $subscriber;

        $this->subject = trans('newsletter.email.confirm.subject');

        $this->greeting = trans('newsletter.email.confirm.greeting', [
            'name' => $this->subscriber->name,
        ]);

        $this->introLines = trans('newsletter.email.confirm.intro');

        $this->outroLines = trans('newsletter.email.confirm.outro');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.default')
            ->subject($this->subject);
    }
}
