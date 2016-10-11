<?php

namespace App\Http\Controllers\Auth\User;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\User\CreateRequest;
use App\Mail\User\CreateMail;
use App\Mail\User\DeleteMail;

/**
 * @author Yugo <dedy.yugo.purwanto@gmail.com>
 * @link https://github.com/arvernester/newsletter
 */
class UserController extends Controller
{
	/**
	 * Show all registered users
	 * 
	 * @return void
	 */
    public function getIndex()
    {
        abort_if(! Gate::allows('users', Auth::user()), 403, 'This action is unauthorized.');
    	
        $users = User::orderBy('name', 'ASC')
            ->with('lists')
            ->paginate(20);

    	return view('auth.user.user.index', compact('users'))
    		->withTitle('Users');
    }

    public function getProfile($id = null)
    {
        # code...
    }

    /**
     * Show create form
     * 
     * @return void
     */
    public function getCreate()
    {
        abort_if(! Gate::allows('users', Auth::user()), 403, 'This action is unauthorized.');
    	
        return view('auth.user.user.create')
    		->withTitle('Create New User');
    }

    /**
     * Save registered user into database
     * 
     * @param  CreateRequest $request
     * @return void            
     */
    public function postCreate(CreateRequest $request)
    {
        abort_if(! Gate::allows('users', Auth::user()), 403, 'This action is unauthorized.');

    	\DB::transaction(function() use($request) {
    	    $user = new User;
	    	$user->name = $request->name;
	    	$user->email = $request->email;
	    	$user->password = '';
	    	$user->remember_token = $request->_token;
	    	$saved = $user->save();

    		// send email confirmation
    		\Mail::to($user->email, $user->name)->queue(new CreateMail($user));

	    	if ($saved === true) {
	    		return redirect()
	    			->route('admin.user')
	    			->with('success', sprintf('New user %s has been created.', $user->name));
	    	}
    	});

    	return redirect()->back();
    }

    /**
     * Delete single row of users
     * 
     * @param  integer $id
     * @return void   
     */
    public function getDelete($id = null)
    {
        abort_if(! Gate::allows('users', Auth::user()), 403, 'This action is unauthorized.');
        
    	abort_if(\Auth::id() == $id, 403, 'You can\'t delete yourself.');

    	$user = User::findOrFail($id);

    	\DB::transaction(function () use($user) {
    	    // send email notification first
    	    \Mail::to($user->email, $user->name)->queue(new DeleteMail($user));

    	    $deleted = $user->delete();

    	    if ($deleted === true) {
    	    	return redirect()
    	    		->route('admin.user')
    	    		->with('success', sprintf('User %s has been deleted.', $user->name));
    	    }
    	});

    	// come here for no reason
    	return redirect()->back();
    }
}
