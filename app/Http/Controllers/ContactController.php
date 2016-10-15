<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\SendRequest;

class ContactController extends Controller
{
    /**
     * Shwo contact form
     *
     * @return void
     */
    public function getIndex()
    {
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
    public function postSend(SendRequest $request)
    {
        \Mail::raw($request->message, function ($mail) use ($request) {
            $mail->to(config('app.email'), config('app.name'))
                ->subject(sprintf('%s dari %s', $request->subject, config('app.name')));
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
