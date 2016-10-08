<?php

namespace App\Http\Controllers\Auth\Newsletter;
use App\Http\Controllers\Controller;

use App\NewsletterList;

class ListController extends Controller
{
    public function getIndex()
    {
    	$lists = NewsletterList::orderBy('name', 'ASC')
    		->get();
    	return view('auth.newsletter.list.index', compact('lists'))
    		->withTitle('Lists');
    }
}
