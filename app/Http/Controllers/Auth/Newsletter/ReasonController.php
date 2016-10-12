<?php

namespace App\Http\Controllers\Auth\Newsletter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Newsletter\Reason\CreateRequest;
use App\NewsletterReason;

/**
 * @author Yugo <dedy.yugo.purwanto>
 *
 * @link https://gihub.com/arvernester/newsletter
 */
class ReasonController extends Controller
{
    /**
     * Show all reasons.
     *
     * @return void
     */
    public function getIndex()
    {
        $reasons = NewsletterReason::get();

        return view('auth.newsletter.reason.index', compact('reasons'))
            ->withTitle('Unsubscribe Reasons');
    }

    /**
     * Get reason detail.
     *
     * @param int $id
     *
     * @return void
     */
    public function getDetail($id = null)
    {
        $reason = NewsletterReason::findOrFail($id);

        if (request()->ajax()) {
            return [
                'isSuccess' => true,
                'content'   => [
                    'id'   => $reason->id,
                    'text' => $reason->description,
                ],
            ];
        }

        return view('auth.newsletter.reason.detail', compact('reason'));
    }

    /**
     * Save new request.
     *
     * @param CreateRequest $request
     *
     * @return void
     */
    public function postCreate(CreateRequest $request)
    {
        $reason = new NewsletterReason();
        $reason->description = $request->description;

        if ($reason->save()) {
            return redirect()
                ->route('admin.reason')
                ->with('success', 'Unsubscribe reason has been created.');
        }

        return redirect()->back();
    }

    /**
     * Edit existing unsubscribe reason.
     *
     * @param EditRequest $request
     *
     * @return void
     */
    public function postEdit(CreateRequest $request)
    {
        $reason = NewsletterReason::findOrFail($request->reason_id);
        $reason->description = $request->description;

        if ($reason->save()) {
            return redirect()
                ->route('admin.reason')
                ->with('success', 'Unsubscribe reason has been edited.');
        }

        return redirect()->back();
    }

    /**
     * Delete single data of reasons.
     *
     * @param int $id
     *
     * @return void
     */
    public function getDelete($id = null)
    {
        $reason = NewsletterReason::findOrFail($id);
        if ($reason->delete()) {
            return redirect()
                ->route('admin.reason')
                ->with('success', 'Unsubscribe reason has been deleted.');
        }

        return redirect()->back();
    }
}
