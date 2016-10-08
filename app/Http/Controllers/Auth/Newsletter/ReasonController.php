<?php

namespace App\Http\Controllers\Auth\Newsletter;
use App\Http\Controllers\Controller;

use App\NewsletterReason;

class ReasonController extends Controller
{
    public function getIndex()
    {
    	$reasons = NewsletterReason::get();

    	return view('auth.newsletter.reason.index', compact('reasons'))
    		->withTitle('Unsubscribe Reasons');
    }
}
