<?php

namespace App\Mail\Newsletter;

use App\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscribeConfirmMail extends Mailable {
	use Queueable, SerializesModels;

	public $subscriber;

	public $level = 'success';

	public $greeting;
	public $introLines;
	public $outroLines;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(NewsletterSubscriber $subscriber) {
		$this->subscriber = $subscriber;

		$this->greeting = 'Halo, ' . $this->subscriber->name;
		$this->introLines = [
			'Pendaftaran kamu telah dikonfirmasi. Terimakasih telah berlangganan di nawala' . config('app.name'),
		];
		$this->outroLines = [
			'Dengan berlangganan nawala, kamu setuju dengan syarat dan ketentuan yang berlaku.',
			'Kami janji tidak ada spam atau email sampah, dan tidak lebih dari satu email setiap minggunya. Kami tidak serajin itu.',
		];
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		return $this->view('email.default')
			->subject('Your Subscription has been Confirmed');
	}
}
