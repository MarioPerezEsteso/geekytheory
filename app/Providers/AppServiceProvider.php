<?php

namespace App\Providers;

use App\Http\Controllers\SiteMetaController;
use Auth;
use Illuminate\Support\Facades\App;
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
        if (!App::runningInConsole()) {
            view()->share('siteMeta', SiteMetaController::getSiteMeta());
        }
        view()->composer('*', function ($view) {
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
