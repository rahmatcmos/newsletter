<?php

namespace App\Http\Controllers\Auth\User;
use App\Http\Controllers\Controller;

use App\User;

class UserController extends Controller
{
    public function getIndex()
    {
    	$users = User::orderBy('name', 'ASC')->paginate(20);

    	return view('auth.user.user.index', compact('users'));
    }
}
