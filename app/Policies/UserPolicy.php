<?php

namespace App\Policies;

use App\User;
use App\User as CurrentUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function index(CurrentUser $currentUser)
    {
        return $currentUser->group === 'admin';
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param App\User $user
     * @param App\User $user
     *
     * @return mixed
     */
    public function view(CurrentUser $currentUser, User $user)
    {
        //
    }

    /**
     * Determine whether the user can create users.
     *
     * @param App\User $user
     *
     * @return mixed
     */
    public function create(CurrentUser $currentUser)
    {
        return $currentUser->group === 'admin';
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param App\User $user
     * @param App\User $user
     *
     * @return mixed
     */
    public function update(CurrentUser $currentUser, User $user)
    {
        //
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param App\User $user
     * @param App\User $user
     *
     * @return mixed
     */
    public function delete(CurrentUser $currentUser, User $user)
    {
        return $currentUser->group === 'admin' and $currentUser->id !== $user->id;
    }
}
