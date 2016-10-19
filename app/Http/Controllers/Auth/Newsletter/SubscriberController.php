<?php

namespace App\Http\Controllers\Auth\Newsletter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Newsletter\CreateSubscriberRequest;
use App\Http\Requests\Newsletter\Subscriber\EditRequest;
use App\Mail\Newsletter\SubscribeMail;
use App\NewsletterList;
use App\NewsletterSubscriber;
use Auth;

/**
 * @author Yugo <dedy.yugo.purwanto@gmail.com>
 *
 * @link https://github.com/arvernester/newsletters
 */
class SubscriberController extends Controller
{
    /**
     * Show subscribers based on list and authenticated user.
     *
     * @param string $listSlug
     *
     * @return void
     */
    public function getIndex($listSlug = null)
    {
        // search list
        if (!empty($listSlug)) {
            $list = NewsletterList::whereSlug($listSlug)->first();
        }

        $subscribers = NewsletterSubscriber::search(request('query'))
            ->paginate(20);

        $subscribers->load('list', 'list.user');

        $labels = [
            'Pending'      => 'warning',
            'Subscribed'   => 'success',
            'Unsubscribed' => 'danger',
        ];

        activity()->withProperties(['query' => request('query')])
            ->log('Viewed subscribers index.');

        return view('auth.newsletter.subscriber.index', compact('subscribers', 'labels', 'lists'))
            ->withTitle(trans('newsletters.subscribers.title', ['total' => $subscribers->total()]));
    }

    /**
     * Show create form.
     *
     * @return void
     */
    public function getCreate()
    {
        return view('auth.newsletter.subscriber.create', compact('lists'))
            ->withTitle('Create New Subscriber');
    }

    /**
     * Save new subscriber to database.
     *
     * @param CreateSubscriberRequest $request
     *
     * @return void
     */
    public function postCreate(CreateSubscriberRequest $request)
    {
        \DB::transaction(function () use ($request) {
            $subscriber = new NewsletterSubscriber();
            $subscriber->newsletter_list_id = $request->list;
            $subscriber->email = $request->email;
            $subscriber->name = $request->name;
            $subscriber->save();

            // save to log
            activity()->performedOn($subscriber)
                ->log('Created subscriber :subject.name (:subject.email)');

            // send email confirmation
            \Mail::to($subscriber->email, $subscriber->name)->queue(new SubscribeMail($subscriber));

            if (!request()->ajax()) {
                session()->flash('success', sprintf('New subscriber named %s (%s) has been created.', $subscriber->name, $subscriber->email));
            }
        });

        if (request()->ajax()) {
            return [
                'isSuccess' => true,
                'message'   => 'Subscriber has been created.',
            ];
        }

        return redirect()
            ->route('admin.subscriber');
    }

    /**
     * Show old data and prepare for edit.
     *
     * @param int $id
     *
     * @return void
     */
    public function getEdit($id)
    {
        $subscriber = NewsletterSubscriber::whereId($id)
            ->firstOrFail();

        return view('auth.newsletter.subscriber.edit', compact('subscriber'))
            ->withTitle(sprintf('Edit Subscriber %s', $subscriber->name));
    }

    /**
     * Save updated subscriber data.
     *
     * @param EditRequest $request
     *
     * @return void
     */
    public function postEdit(EditRequest $request)
    {
        $subscriber = new NewsletterSubscriber();
        $subscriber->name = $request->name;
        $subscriber->email = $request->email;
        $subscriber->newsletter_list_id = $request->list;

        if ($subscriber->save() === true) {
            activity()->performedOn($subscriber)
                ->log('Updated subscriber :subject.name (:subject.email)');

            return redirect()
                ->route('admin.subscriber')
                ->with('success', sprintf('Subscriber %s has been updated.', $subscriber->name));
        }

        return redirect()->back();
    }

    /**
     * Delete single row of subscriber where has belongs to user.
     *
     * @param int $id
     *
     * @return void
     */
    public function getDelete($id = null)
    {
        $subscriber = NewsletterSubscriber::whereHas('list', function ($query) {
            return $query->whereUserId(Auth::id());
        })
            ->whereId($id)
            ->firstOrFail();

        $oldSubscriber = [
            'email' => $subscriber->email,
            'name'  => $subscriber->name,
        ];

        if ($subscriber->delete() === true) {
            activity()->withProperties($oldSubscriber)
                ->log('Deleted subscriber :properties.name (:properties.email)');

            return redirect()
                ->back()
                ->with('success', sprintf('Subscriber %s has been deleted.', $subscriber->email));
        }
    }

    /**
     * Delete all subscriber data performed by admin.
     *
     * @return void
     */
    public function deleteTruncate()
    {
        $this->authorize('truncate', NewsletterSubscriber::class);

        $truncated = NewsletterSubscriber::truncate();
        activity()->log('Truncated all subscribers');

        return redirect()
            ->route('admin.subscriber')
            ->with('success', 'All subscribers has been removed.');
    }
}
