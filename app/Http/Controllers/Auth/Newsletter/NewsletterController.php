<?php

namespace App\Http\Controllers\Auth\Newsletter;
use App\Http\Controllers\Controller;

use App\Newsletter;

/**
 * @author Yugo <dedy.yugo.purwanto@gmail.com>
 * @link https://www.github.com/arvernester/newsletter
 */
class NewsletterController extends Controller
{
    public function getIndex()
    {
    	$newsletters = Newsletter::orderBy('name')
    		->paginate(20);
    		
    	return view('content.admin.newsletter.index', compact('newsletters'));
    }
}
