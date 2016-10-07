<?php

namespace App\Http\Controllers;

use App\Subscriber;
use App\Http\Requests\Newsletter\SubscribeRequest;
use App\Mail\Newsletter\SubscribeMail;

class NewsletterController extends Controller
{
    public function getIndex()
    {
    	return view('newsletter.index')
    		->withTitle('Subscribe Newsletter');
    }

    public function postSubscribe(SubscribeRequest $request)
    {
    	\DB::transaction(function() use($request){
    		// save to database
	    	$subscriber = Subscriber::FirstOrNew(['email' => $request->email]);
	    	$subscriber->name = $request->name;
	    	$subscriber->status = 'unsubscribed';
	    	$subscriber->save();

	    	// send email confirmation
            \Mail::to($subscriber->email, $subscriber->name)->queue(new SubscribeMail($subscriber)); 
    	});

    	return redirect()
    		->route('newsletter.index')
    		->with('success', 'Thank you for registering our newsletter. Please check your inbox.');    	
    }

    public function getConfirm()
    {
        $email = \Crypt::decrypt(request('email'));
        abort_if(empty($email), 404, 'Email address not found.');

        // find email
        $subscriber = Subscriber::whereEmail($email)->first();
        if (empty($subscriber)) {
            return redirect()
                ->route('newsletter.index')
                ->with('error', 'Invalid email address.');
        }

        $subscriber->status = 'subscribe';
        $subscriber->save();

        return redirect()
            ->route('newsletter.index')
            ->with('success', 'You has been subscribed newsletter.');
    }
}
