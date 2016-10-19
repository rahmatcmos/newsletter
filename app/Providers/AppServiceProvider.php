<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // setup global setting
        if (Schema::hasTable('settings')) {
            $settings = \Cache::get('setting', function () {
                return \App\Setting::orderBy('key', 'ASC')->get();
            });

            foreach ($settings as $setting) {
                $key = str_replace('_', '.', $setting->key);
                config([$key => $setting->value]);
            }
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->environment() === 'local') {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
