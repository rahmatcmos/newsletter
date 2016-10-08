<?php

namespace App\Http\Controllers\Auth\Newsletter;
use App\Http\Controllers\Controller;

use App\Subscriber;
use App\Http\Requests\Newsletter\SubscribeRequest;
use App\Mail\Newsletter\SubscribeMail;

class SubscriberController extends Controller
{
    public function getIndex()
    {
    	$subscribers = Subscriber::select('name', 'email', 'created_at', 'status')
            ->filter()
            ->sort()
    		->paginate(20);

    	$labels = [
    		'Pending' => 'warning',
    		'Subscribed' => 'success',
    		'Unsubscribed' => 'danger'
    	];

    	return view('auth.newsletter.subscriber.index', compact('subscribers', 'labels'))
    		->withTitle(sprintf('Subscribers (%d)', $subscribers->total()));
    }

    public function getCreate()
    {
        return view('auth.newsletter.subscriber.create');
    }

    public function postCreate(SubscribeRequest $request)
    {
        \DB::transaction(function() use($request){
            $subscriber = Subscriber::FirstOrNew(['email' => $request->email]);
            $subscriber->name = $request->name;
            $subscriber->save();

            // send email confirmation
            \Mail::to($subscriber->email, $subscriber->name)->queue(new SubscribeMail($subscriber));

            return redirect()
                ->route('admin.subscriber')
                ->with('success', sprintf('New subscriber named %s (%s) has been created.', $subscriber->name, $subscriber->email));
        });

        return redirect()->back();
    }

    public function getDelete($id = null)
    {
        abort_if(empty($id), 404, $message = 'Subscribed ID is not defined.');
        \Log::warning($message);

        $subscriber = Subscriber::find($id);
        if (empty($subscriber)) {
            return redirect()
                ->route('admin.subscriber')
                ->with('error', 'Subscriber not found.');
        }

        $subscriber->delete();
        return redirect()
            ->back()
            ->with('success', sprintf('Subscriber %s has been deleted.', $subscriber->email));
    }
}
