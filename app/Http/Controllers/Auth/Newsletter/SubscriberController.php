<?php

namespace App\Http\Controllers\Auth\Newsletter;
use App\Http\Controllers\Controller;

use App\Subscriber;
use App\NewsletterList;
use App\Http\Requests\Newsletter\CreateSubscriberRequest;
use App\Mail\Newsletter\SubscribeMail;

class SubscriberController extends Controller
{
    public function getIndex($listSlug = null)
    {
        // search list
        if (! empty($listSlug)) {
            $list = NewsletterList::whereSlug($listSlug)->first();
        }

    	$subscribers = Subscriber::select('id', 'newsletter_list_id', 'name', 'email', 'created_at', 'status')
            ->with('list')
            ->filter(isset($list) ? $list : null)
            ->sort()
    		->paginate(20);

    	$labels = [
    		'Pending' => 'warning',
    		'Subscribed' => 'success',
    		'Unsubscribed' => 'danger'
    	];

    	return view('auth.newsletter.subscriber.index', compact('subscribers', 'labels', 'lists'))
    		->withTitle(sprintf('Subscribers (%d)', $subscribers->total()));
    }

    public function getCreate()
    {
        $lists = NewsletterList::select('name', 'id')
            ->orderBy('is_default', 'DESC')
            ->orderBy('name', 'ASC')
            ->get();

        return view('auth.newsletter.subscriber.create', compact('lists'))
            ->withTitle('Create New Subscriber');
    }

    public function postCreate(CreateSubscriberRequest $request)
    {
        \DB::transaction(function() use($request){
            $subscriber = Subscriber::FirstOrNew(['email' => $request->email]);
            $subscriber->newsletter_list_id = $request->list;
            $subscriber->name = $request->name;
            $subscriber->save();

            // send email confirmation
            \Mail::to($subscriber->email, $subscriber->name)->queue(new SubscribeMail($subscriber));

            if (! request()->ajax()) {
                session()->flash('success', sprintf('New subscriber named %s (%s) has been created.', $subscriber->name, $subscriber->email));
            }
        });

        if (request()->ajax()) {
            return [
                'isSuccess' => true,
                'message' => 'Subscriber has been created.'
            ];
        }

        return redirect()
            ->route('admin.subscriber');
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
