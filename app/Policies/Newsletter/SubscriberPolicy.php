<?php

namespace App\Policies\Newsletter;

use App\NewsletterSubscriber;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriberPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the newsletterSubscriber.
     *
     * @param App\User                 $user
     * @param App\NewsletterSubscriber $newsletterSubscriber
     *
     * @return mixed
     */
    public function view(User $user, NewsletterSubscriber $newsletterSubscriber)
    {
        //
    }

    /**
     * Determine whether the user can create newsletterSubscribers.
     *
     * @param App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the newsletterSubscriber.
     *
     * @param App\User                 $user
     * @param App\NewsletterSubscriber $newsletterSubscriber
     *
     * @return mixed
     */
    public function update(User $user, NewsletterSubscriber $newsletterSubscriber)
    {
        //
    }

    /**
     * Determine whether the user can delete the newsletterSubscriber.
     *
     * @param App\User                 $user
     * @param App\NewsletterSubscriber $newsletterSubscriber
     *
     * @return mixed
     */
    public function delete(User $user, NewsletterSubscriber $newsletterSubscriber)
    {
        //
    }

    /**
     * Determine whether only admin can truncate all newsletter subscriber.
     *
     * @param User $user
     *
     * @return bool
     */
    public function truncate(User $user)
    {
        return $user->group === 'admin';
    }
}
