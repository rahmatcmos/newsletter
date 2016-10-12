<?php

namespace App\Http\Controllers\Auth\Newsletter;

use App\Http\Controllers\Controller;
use App\Newsletter;
use App\NewsletterSubsciber;
use Auth;

/**
 * @author Yugo <dedy.yugo.purwanto@gmail.com>
 *
 * @link https://www.github.com/arvernester/newsletter
 */
class NewsletterController extends Controller
{
    /**
     * Show all newsletters.
     *
     * @return void
     */
    public function getIndex()
    {
        $newsletters = Newsletter::orderBy('title', 'ASC')
            ->filter()
            ->paginate(20);

        return view('auth.newsletter.newsletter.index', compact('newsletters'))
            ->withTitle('Newsletter Templates');
    }

    /**
     * View newsletter detail and prepare send to subscribers.
     *
     * @param int $id
     *
     * @return void
     */
    public function getDetail($id = null)
    {
        $newsletter = Newsletter::findOrFail($id);

        if (request()->ajax()) {
            return [
                'isSuccess' => true,
                'content'   => [
                    'id'         => $newsletter->id,
                    'title'      => $newsletter->title,
                    'content'    => $newsletter->content,
                    'createdAt'  => $newsletter->created_at->format('d.m.Y H.i'),
                    'updated_at' => $newsletter->updated_at->format('d.m.Y H.i'),
                ],
            ];
        }

        return view('auth.newsletter.newsletter.detail', compact('newsletter'))
            ->withTitle($newsletter->title);
    }

    /**
     * Fill empty form.
     *
     * @return void
     */
    public function getCreate()
    {
        return view('auth.newsletter.newsletter.create');
    }

    /**
     * Save new newsletter.
     *
     * @param CreateRequest $request
     *
     * @return void
     */
    public function postCreate(CreateRequest $request)
    {
        $newsletter = new Newsletter();
        $newsletter->user_id = \Auth::id();
        $newsletter->title = $request->title;
        $newsletter->content = $request->content;

        if ($newsletter->save()) {
            return redirect()
                ->route('admin.newsletter.detail', $newsletter->id)
                ->with('success', 'Newsletter has been created.');
        }

        return redirect()->back();
    }

    /**
     * Get detail data and fill it into edit form.
     *
     * @param int $id
     *
     * @return void
     */
    public function getEdit($id = null)
    {
        abort_if(empty($id), 404, 'Identifier is not defined.');
        $newsletter = Newsletter::findOrFail($id);

        return view('auth.newsletter.newsletter.edit', compat('edit'));
    }

    /**
     * Save updated newsletter.
     *
     * @param EditNewsletterRequest $request
     *
     * @return void
     */
    public function postEdit(EditNewsletterRequest $request)
    {
        $newsletter = Newsletter::whereUserId(Auth::id())
            ->whereId($request->id)
            ->findOrFail();

        $newsletter->title = $request->title;
        $newsletter->content = $request->content;

        if ($newsletter->save() === true) {
            return redirect()
                ->route('admin.newsletter.detail', $newsletter->id)
                ->with('success', 'Newsletter has been updated.');
        }

        return redirect()->back();
    }

    /**
     * Delete single data of newsletter.
     *
     * @param int $id
     *
     * @return void
     */
    public function getDelete($id = null)
    {
        abort_if(empty($id), 404, 'Identifier is not defined.');
        $newsletter = Newsletter::whereUserId(Auth::id())
            ->whereId($id)
            ->findOrFail();

        if ($newsletter->delete() === true) {
            return redirect()
                ->route('admin.newsletter')
                ->with('success', sprintf('Newsletter %s has been deleted.', $newsletter->title));
        }

        return redirect()->back();
    }

    /**
     * Send newsletter to spesified subscriber or all.
     *
     * @return void
     */
    public function postSend(NewsletterSendRequest $request)
    {
        $newsletter = Newsletter::findOrFail(request('id'));

        switch ($request->type) {
            case 'specified':
                if (!empty($request->emails)) {
                    $subscribers = NewsletterSubsciber::whereIn('email', request('emails'))->get();
                } else {
                    $subscribers = NewsletterSubsciber::where('newsletter_list_id', $request->list_id)->get();
                }
                break;

            default:
                $subscribers = NewsletterSubsciber::whereStatus('subscribed')->get();
                break;
        }

        // to avoid time out, it must be use Laravel queue
        foreach ($subscribers as $subscriber) {
            \Mail::to($subscriber->email, $subscriber->name)
                ->queue(new NewsletterMail($subscriber, $newsletter));
        }

        return redirect()
            ->back()
            ->with('success', 'Newsletter has been sent to all subscribers.');
    }
}
