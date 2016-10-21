<?php

namespace App\Http\Controllers\Auth\Newsletter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Newsletter\CreateListRequest;
use App\Http\Requests\Newsletter\EditListRequest;
use App\NewsletterList;
use Auth;
use DB;

/**
 * @author Yugo <dedy.yugo.purwanto@gmail.com>
 *
 * @link https://github.com/arvernester/newsletter
 */
class ListController extends Controller
{
    /**
     * Show all lists.
     *
     * @return void
     */
    public function getIndex()
    {
        $lists = NewsletterList::orderBy('name', 'ASC')
            ->with('subscribers')
            ->filter()
            ->paginate(20);

        if (Auth::user()->group === 'admin') {
            $lists->load('user');
        }

        if (request()->ajax()) {
            return [
                'isSuccess' => true,
                'content'   => $lists->map(function ($list) {
                    return [
                        'id'   => $list->id,
                        'name' => $list->name,
                    ];
                }),
            ];
        }

        return view('auth.newsletter.list.index', compact('lists'))
            ->withTitle(trans('newsletter.lists.title'));
    }

    /**
     * Create new list and save to database.
     *
     * @param CreateListRequest $request
     *
     * @return void
     */
    public function postCreate(CreateListRequest $request)
    {
        $transaction = DB::transaction(function () use ($request) {

            $list = new NewsletterList();
            $list->user_id = Auth::id();
            $list->slug = str_slug($request->name);
            $list->name = $request->name;
            $list->description = $request->description;
            $list->is_default = false;
            $saved = $list->save();

            activity()->performedOn($list)
                ->withProperties([
                    'id'   => $list->id,
                    'name' => $list->name,
                ])
                ->log('newsletter.lists.log.create');

            return $saved;
        });

        if ($transaction === true) {
            return redirect()
                ->route('admin.list')
                ->withSuccess(trans('newsletter.lists.message.created', ['name' => $list->name]));
        }

        return redirect()->back();
    }

    /**
     * Show form to edit existing list.
     *
     * @param int $id
     *
     * @return void
     */
    public function getEdit($id = null)
    {
        $list = NewsletterList::when(Auth::user()->group === 'user', function ($query) {
            return $query->whereUserId(Auth::id());
        })
            ->whereId($id)
            ->firstOrFail();

        return view('auth.newsletter.list.edit', compact('list'))
            ->withTitle(trans('newsletter.lists.edit', ['name' => $list->name]));
    }

    /**
     * Save to database.
     *
     * @param EditListRequest $request
     *
     * @return void
     */
    public function postEdit(EditListRequest $request)
    {
        $transaction = DB::transaction(function () use ($request) {
            $list = NewsletterList::when(Auth::user()->group === 'user', function ($query) {
                return $query->whereUserId(Auth::id());
            })
                ->whereId($request->id)
                ->firstOrFail();

            $list->name = $request->name;
            $list->description = $request->description;
            $saved = $list->save();

            activity()->performedOn($list)
                ->withProperties([
                    'id'   => $list->id,
                    'name' => $list->name,
                ])
                ->log('newsletter.lists.log.edit');

        });

        if ($transaction === true) {
            return redirect()
                ->route('admin.list')
                ->withSuccess(trans('newsletter.lists.message.edited', ['name' => $list->name]));
        }

        // come for no reason
        return redirect()->back();
    }

    /**
     * Delete single row of list.
     *
     * @param int $id
     *
     * @return void
     */
    public function getDelete($id = null)
    {
        $list = NewsletterList::when(Auth::user()->group === 'user', function ($query) {
            return $query->whereUserId(Auth::id());
        })
            ->whereId($id)
            ->firstOrFail();

        $transaction = DB::transaction(function () use ($list) {
            $listProperties = [
                'id'   => $list->id,
                'name' => $list->name,
            ];

            $deleted = $list->delete();

            activity()->performedOn($list)
                ->withProperties($listProperties)
                ->log('newsletter.lists.log.delete');

            return $deleted;
        });

        if ($transaction === true) {
            return redirect()
                ->route('admin.list')
                ->withSuccess('newsletter.lists.message.deleted');
        }

        // come for no reason
        return redirect()->back();
    }
}
