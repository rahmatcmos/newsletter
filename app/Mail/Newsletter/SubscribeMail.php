<?php

namespace App\Mail\Newsletter;

use App\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscribeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriber;

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
    public $actionText = 'Konfirmasi Berlangganan';

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

        $this->greeting = 'Hello, '.$this->subscriber->name;

        $this->introLines = [
            'Terimakasih telah mengisi form pendaftaran untuk berlangganan Nawala.',
            'Tinggal satu langkah lagi agar kamu mendapatkan informasi terbaru melalui kotak masuk.',
        ];

        $this->actionUrl = route('newsletter.confirm', [
            'key'        => \Crypt::encrypt($this->subscriber->email),
            'utm_source' => 'emal',
        ]);

        $this->outroLines = [
            'Dengan mengklik "Konfirmasi Berlangganan", kamu setuju dengan syarat dan ketentuan yang berlaku.',
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.default')
            ->subject('Confirm Your Subscription');
    }
}
