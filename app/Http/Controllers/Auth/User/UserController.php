<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\DeleteRequest;
use App\Http\Requests\User\EditRequest;
use App\Mail\User\CreateMail;
use App\Mail\User\DeleteMail;
use App\User;
use Auth;
use DB;
use Spatie\Activitylog\Models\Activity;

/**
 * @author Yugo <dedy.yugo.purwanto@gmail.com>
 *
 * @link https://github.com/arvernester/newsletter
 */
class UserController extends Controller
{
    public function __construct()
    {
        config(['laravel-activitylog.default_log_name' => 'user']);
    }
    /**
     * Show all registered users.
     *
     * @return void
     */
    public function getIndex()
    {
        $this->authorize('index', User::class);

        activity()->log('user.log.view');

        $users = User::orderBy('name', 'ASC')
            ->with('lists')
            ->paginate(20);

        return view('auth.user.user.index', compact('users'))
            ->withTitle(trans('user.title'));
    }

    /**
     * Show user profile by logged session or provider id.
     *
     * @param int $id
     *
     * @return void
     */
    public function getProfile($id = null)
    {
        if (empty($id)) {
            $user = Auth::user();
        } else {
            $user = User::find($id);
            abort(404, trans('user.message.notFound'));
        }

        if ($user->id !== Auth::id()) {
            activity()->performedOn($user)
                ->withProperties(['name' => $user->name])
                ->log('user.log.viewProfile');
        }

        $activities = Activity::whereCauserId($user->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return view('auth.user.user.profile', compact('user', 'activities'))
            ->withTitle($user->name);
    }

    /**
     * Show create form.
     *
     * @return void
     */
    public function getCreate()
    {
        $this->authorize('create', User::class);

        $groups = User::getGroups();

        return view('auth.user.user.create', compact('groups'))
            ->withTitle(trans('user.create'));
    }

    /**
     * Save registered user into database.
     *
     * @param CreateRequest $request
     *
     * @return void
     */
    public function postCreate(CreateRequest $request)
    {
        $this->authorize('create', User::class);

        $transaction = \DB::transaction(function () use ($request) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            if (!empty($request->password)) {
                $user->password = bcrypt($request->password);
            } else {
                $user->password = '';
            }
            $user->remember_token = $request->_token;
            $user->group = $request->group;
            $saved = $user->save();

            // send email confirmation
            \Mail::to($user->email, $user->name)->queue(new CreateMail($user));

            activity()->performedOn($user)
                ->withProperties(['name' => $user->name])
                ->log('user.log.created');

            return [
                'status' => $saved,
                'user'   => $user,
            ];
        });

        if ($transaction['status'] === true) {
            return redirect()
                ->route('admin.user')
                ->withSuccess(trans('user.message.created', ['name' => $transaction['user']->name]));
        }

        return redirect()->back();
    }

    /**
     * Show form and prepare data editing
     *
     * @param $id
     */
    public function getEdit($id)
    {
        $user = User::find($id);
        if (empty($user)) {
            abort(404, trans('user.message.notFound'));
        }

        $groups = User::getGroups();

        return view('auth.user.user.edit', compact('user', 'groups'))
            ->withTitle(trans('user.edit', ['name' => $user->name]));
    }

    /**
     * Edit existing user data
     *
     * @param EditRequest $request
     */
    public function putEdit(EditRequest $request)
    {
        $user = User::find($request->id);

        $transaction = DB::transaction(function () use ($user, $request) {
            $user->name = $request->name;
            $saved = $user->save();

            activity()->performedOn($user)
                ->withProperties(['name' => $user->name])
                ->log('user.log.edit');

            return [
                'status' => $saved,
                'user'   => $user,
            ];
        });

        if ($transaction['status'] === true) {
            return redirect()
                ->route('admin.user.edit', $transaction['user']->id)
                ->withSuccess(trans('user.message.edited', ['name' => $transaction['user']->name]));
        }

        return redirect()->back();
    }

    /**
     * Delete single row of users.
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteDelete(DeleteRequest $request)
    {
        $user = User::find($request->id);

        $this->authorize('delete', $user);

        $transaction = DB::transaction(function () use ($user) {
            // send email notification first
            \Mail::to($user->email, $user->name)->queue(new DeleteMail($user));

            activity()->performedOn($user)
                ->withProperties(['name' => $user->name])
                ->log('Deleted user :subject.name');

            $deleted = $user->delete();

            return [
                'status' => $deleted,
                'user'   => $user,
            ];
        });

        if ($transaction['status'] === true) {
            return redirect()
                ->route('admin.user')
                ->withSuccess('user.log.delete');
        }

        // come here for no reason
        return redirect()->back();
    }
}
