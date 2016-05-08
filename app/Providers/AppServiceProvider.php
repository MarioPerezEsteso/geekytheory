<?php

namespace App\Providers;

use App\SiteMeta;
use Auth;
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
        view()->share('siteMeta', SiteMeta::first());
        view()->composer('*', function($view) {
            $user = Auth::user();
            if ($user != null) {
                $view->with('user', Auth::user()->getBasicUserData());
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
