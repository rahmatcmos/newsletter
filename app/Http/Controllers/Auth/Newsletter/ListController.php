<?php

namespace App\Http\Controllers\Auth\Newsletter;
use App\Http\Controllers\Controller;

use App\NewsletterList;
use App\Http\Requests\Newsletter\CreateListRequest;

class ListController extends Controller
{
    public function getIndex()
    {
    	$lists = NewsletterList::orderBy('name', 'ASC')
            ->with('subscribers')
    		->paginate(20);

        if (request()->ajax()) {
            return [
                'isSuccess' => true,
                'content' => $lists->map(function($list){
                    return [
                        'id' => $list->id,
                        'name' => $list->name
                    ];
                })
            ];
        }

    	return view('auth.newsletter.list.index', compact('lists'))
    		->withTitle('Lists');
    }

    public function postCreate(CreateListRequest $request)
    {
    	$list = new NewsletterList;
    	$list->slug = str_slug($request->name);
    	$list->name = $request->name;
    	$list->description = $request->description;
    	$list->is_default = false;
    	$list->save();

    	return redirect()
    		->route('admin.list')
    		->with('success', sprintf('New list named %s has been created.', $list->name));
    }
}
