<?php

namespace App\Mail\Newsletter;

use App\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscribeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Set email subject
     *
     * @var [type]
     */
    public $subject;

    /**
     * Emai level (success, error).
     *
     * @var string
     */
    public $level = 'success';

    /**
     * Set greeting text.
     *
     * @var string
     */
    public $greeting;

    /**
     * Action URL.
     *
     * @var string
     */
    public $actionUrl;

    /**
     * ACtion text.
     *
     * @var string
     */
    public $actionText;

    /**
     * Intro lines.
     *
     * @var array
     */
    public $introLines = [];

    /**
     * Outro lines.
     *
     * @var array
     */
    public $outroLines = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(NewsletterSubscriber $subscriber)
    {
        $this->subscriber = $subscriber;

        $this->subject = trans('newsletter.email.subscribe.subject');

        $this->greeting = trans('newsletter.email.subscribe.greeting', [
            'name' => $this->subscriber->name,
        ]);

        $this->introLines = trans('newsletter.email.subscribe.intro');

        $this->actionText = trans('newsletter.email.subscribe.actionText');

        $this->actionUrl = route('newsletter.confirm', [
            'key' => \Crypt::encrypt($this->subscriber->email),
            'utm_source' => 'emal',
        ]);

        $this->outroLines = trans('newsletter.email.subscribe.outro');
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
