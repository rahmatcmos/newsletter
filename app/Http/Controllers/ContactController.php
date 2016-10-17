<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\SendRequest;
use File;

/**
 * @author Yugo <dedy.yugo.purwanto@gmail.com>
 * @copyright 2016 - Laravel Newsletter
 */
class ContactController extends Controller {

	/**
	 * Show contact form
	 *
	 * @return void
	 */
	public function getIndex() {
		$subjects = [
			'Pertanyaan',
			'Kritik dan Saran',
			'Laporan Bug',
			'Lainnya',
		];
		return view('contact.index', compact('subjects'))
			->withTitle('Get in touch');
	}

	/**
	 * Send message as email
	 *
	 * @return void
	 */
	public function postSend(SendRequest $request) {
		// upload image first
		$attachs = [];
		if (!empty($request->attach) AND $request->attach->isValid()) {
			$path = public_path('storage/contact');
			if (!File::isDirectory($path)) {
				File::makeDirectory($path, 0777, true);
			}

			$fileName = sprintf('%s-%s.%s',
				'contact',
				time(),
				$request->attach->getClientOriginalExtension()
			);

			if ($request->attach->move($path, $fileName)) {
				$attachs[] = $path . '/' . $fileName;
			}
		}

		\Mail::raw($request->message, function ($mail) use ($request, $attachs) {
			$mail->to(config('app.email'), config('app.name'))
				->subject(sprintf('%s dari %s', $request->subject, config('app.name')));

			if (!empty($attachs)) {
				foreach ($attachs as $attach) {
					$mail->attach($attach);
				}
			}
		});

		if (empty(\Mail::failures())) {
			return redirect()
				->back()
				->with('success', 'Message has been sent.');
		}

		return redirect()
			->back()
			->with('error', 'Failed to send message. Please try again.');
	}
}
