<?php

namespace App\Http\Controllers\Auth\Newsletter;
use App\Http\Controllers\Controller;

use App\Subscriber;

class SubscriberController extends Controller
{
    public function getIndex()
    {
    	$subscribers = Subscriber::orderBy('name')
    		->paginate(20);

    	$labels = [
    		'Pending' => 'warning',
    		'Subscribed' => 'success',
    		'Unsubscribed' => 'danger'
    	];

    	return view('auth.newsletter.subscriber.index', compact('subscribers', 'labels'))
    		->withTitle(sprintf('Subscribers (%d)', $subscribers->total()));
    }
}
