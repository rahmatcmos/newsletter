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

    	return view('content.admin.newsletter.subscriber.index', compact('subscribers'))
    		->withTitle(sprintf('Subscribers (%d)', $subscribers->total()));
    }
}
