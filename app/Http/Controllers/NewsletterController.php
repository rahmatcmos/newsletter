<?php

namespace App\Http\Controllers;

use App\Http\Requests\Newsletter\SubscribeRequest;
use App\Mail\Newsletter\SubscribeConfirmMail;
use App\Mail\Newsletter\SubscribeMail;
use App\NewsletterList;
use App\NewsletterSubscriber;
use Log;

/**
 * @author Yugo <dedy.yugo.purwanto>
 *
 * @link https://github.com/arvernester/newsletter
 */
class NewsletterController extends Controller
{
    /**
     * Show subscribe form.
     *
     * @return void
     */
    public function getIndex()
    {
        $list = NewsletterList::find(config('newsletter.list'));
        if (empty($list)) {
            Log::critical('Default list is not defined.', ['url' => route('newsletter.index')]);

            abort(500, 'Default list is not defined. Please <a href="' . route('contact') . '">contact</a> our sys admin for more information.');
        }

        return view('newsletter.index')
            ->withTitle('Subscribe Newsletter');
    }

    /**
     * Save to database as pending subscription.
     *
     * @param SubscribeRequest $request
     *
     * @return void
     */
    public function postSubscribe(SubscribeRequest $request)
    {
        abort_if(empty(config('newsletter.list')), 500, 'Default list is not defined.');

        \DB::transaction(function () use ($request) {
            // get default list
            $list = NewsletterList::findOrFail(config('newsletter.list'));

            // save to database
            $subscriber = NewsletterSubscriber::FirstOrNew([
                'email' => $request->email,
                'newsletter_list_id' => config('newsletter.list'),
            ]);

            $subscriber->name = $request->name;
            $subscriber->status = 'pending';
            $subscriber->save();

            // send email confirmation
            \Mail::to($subscriber->email, $subscriber->name)->queue(new SubscribeMail($subscriber));
        });

        return redirect()
            ->route('newsletter.index')
            ->with('success', 'Thank you for registering our newsletter. Please check your inbox.');
    }

    /**
     * Confirm status as subscriber.
     *
     * @return void
     */
    public function getConfirm()
    {
        $email = \Crypt::decrypt(request('key'));
        abort_if(empty($email), 404, 'Email address not found.');

        // find email
        $subscriber = NewsletterSubscriber::whereEmail($email)->first();
        if (empty($subscriber)) {
            return redirect()
                ->route('newsletter.index')
                ->with('error', 'Invalid email address.');
        }

        $subscriber->status = 'subscribed';
        $subscriber->save();

        // send email notification
        \Mail::to($subscriber->email, $subscriber->name)->queue(new SubscribeConfirmMail($subscriber));

        return redirect()
            ->route('newsletter.index')
            ->with('success', 'You has been subscribed newsletter.');
    }

    /**
     * Show dissapointed text and reason form.
     *
     * @return void
     */
    public function getUnsubscribe()
    {
        $reasons = \App\NewsletterReason::all();

        return view('newsletter.unsubscribe', compact('reasons'))
            ->withTitle('Unsubscribe Newsletter');
    }
}
