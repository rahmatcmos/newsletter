<?php

namespace App\Http\Controllers\Auth\Newsletter;
use App\Http\Controllers\Controller;

use Auth;
use App\NewsletterSubscriber;
use App\NewsletterList;
use App\Http\Requests\Newsletter\CreateSubscriberRequest;
use App\Mail\Newsletter\SubscribeMail;

/**
 * @author Yugo <dedy.yugo.purwanto@gmail.com>
 * @link https://github.com/arvernester/newsletters
 */
class SubscriberController extends Controller
{
    /**
     * Show subscribers based on list and authenticated user
     * 
     * @param  string $listSlug
     * @return void         
     */
    public function getIndex($listSlug = null)
    {
        // search list
        if (! empty($listSlug)) {
            $list = NewsletterList::whereSlug($listSlug)->first();
        }

    	$subscribers = NewsletterSubscriber::select('id', 'newsletter_list_id', 'name', 'email', 'created_at', 'status')
            ->with('list')
            ->filter(isset($list) ? $list : null)
            ->sort()
    		->paginate(20);

        if (Auth::user()->group === 'admin') {
            $subscribers->load('list.user');
        }

    	$labels = [
    		'Pending' => 'warning',
    		'Subscribed' => 'success',
    		'Unsubscribed' => 'danger'
    	];

    	return view('auth.newsletter.subscriber.index', compact('subscribers', 'labels', 'lists'))
    		->withTitle(sprintf('Subscribers (%d)', $subscribers->total()));
    }

    /**
     * Show create form
     * 
     * @return void
     */
    public function getCreate()
    {
        return view('auth.newsletter.subscriber.create', compact('lists'))
            ->withTitle('Create New Subscriber');
    }

    /**
     * Save new subscriber to database
     * 
     * @param  CreateSubscriberRequest $request
     * @return void                  
     */
    public function postCreate(CreateSubscriberRequest $request)
    {
        \DB::transaction(function() use($request){
            $subscriber = new NewsletterSubscriber;
            $subscriber->newsletter_list_id = $request->list;
            $subscriber->email = $request->email;
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

    /**
     * Delete single row of subscriber where has belongs to user
     * 
     * @param  integer $id
     * @return void 
     */
    public function getDelete($id = null)
    {
        $subscriber = NewsletterSubscriber::whereHas('list', function($query){
                return $query->whereUserId(Auth::user()->id);
            })
            ->whereId($id)
            ->firstOrFail();

        if ($subscriber->delete() === true) {
            return redirect()
                ->back()
                ->with('success', sprintf('Subscriber %s has been deleted.', $subscriber->email));
        }
    }
}
