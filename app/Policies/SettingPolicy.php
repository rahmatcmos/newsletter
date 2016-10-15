<?php

namespace App\Policies;

use App\Setting;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the setting.
     *
     * @param App\User    $user
     * @param App\Setting $setting
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->group === 'admin';
    }

    /**
     * Determine whether the user can create settings.
     *
     * @param App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->group === 'admin';
    }

    /**
     * Determine whether the user can update the setting.
     *
     * @param App\User    $user
     * @param App\Setting $setting
     *
     * @return mixed
     */
    public function update(User $user, Setting $setting)
    {
        //
    }

    /**
     * Determine whether the user can delete the setting.
     *
     * @param App\User    $user
     * @param App\Setting $setting
     *
     * @return mixed
     */
    public function delete(User $user, Setting $setting)
    {
        //
    }

    /**
     * Only admin group can test email.
     *
     * @param User $user
     *
     * @return bool
     */
    public function email(User $user)
    {
        return $user->group === 'admin';
    }
}
