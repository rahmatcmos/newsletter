<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\NewsletterSubscriber::class => \App\Policies\Newsletter\SubscriberPolicy::class,
        \App\Setting::class => \App\Policies\SettingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // define gate for users
        Gate::define('users', function ($user) {
            return $user->group === 'admin';
        });
    }
}
