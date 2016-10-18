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
            Log::critical(trans('newsletter.message.noDefaultList'), ['url' => route('newsletter.index')]);

            abort(500, trans('newsletter.message.errorNoDefaultList'));
        }

        return view('newsletter.index')
            ->withTitle(trans('newsletter.subscribe'));
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
        abort_if(empty(config('newsletter.list')), 500, trans('newsletter.message.noDefaultList'));

        \DB::transaction(function () use ($request) {
            // get default list
            $list = NewsletterList::findOrFail(config('newsletter.list'));

            // save to database
            $subscriber = NewsletterSubscriber::FirstOrNew([
                'email'              => $request->email,
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
            ->with('success', trans('newsletter.message.subscribed'));
    }

    /**
     * Confirm status as subscriber.
     *
     * @return void
     */
    public function getConfirm()
    {
        $email = \Crypt::decrypt(request('key'));
        abort_if(empty($email), 404, trans('newsletter.message.emailNotFound'));

        // find email
        $subscriber = NewsletterSubscriber::whereEmail($email)->first();
        if (empty($subscriber)) {
            return redirect()
                ->route('newsletter.index')
                ->with('error', trans('newsletter.message.emailInvalid'));
        }

        $subscriber->status = 'subscribed';
        $subscriber->save();

        // send email notification
        \Mail::to($subscriber->email, $subscriber->name)->queue(new SubscribeConfirmMail($subscriber));

        return redirect()
            ->route('newsletter.index')
            ->withSuccess(trans('newsletter.message.confirmed'));
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
            ->withTitle(trans('newsletter.unsubscribe'));
    }
}
