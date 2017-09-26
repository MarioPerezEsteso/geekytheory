<?php

namespace App\Providers;

use App\Http\Controllers\SiteMetaController;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $siteMeta = null;
        if (!App::runningInConsole()) {
            $siteMeta = SiteMetaController::getSiteMeta();
        }
        view()->share('siteMeta', $siteMeta);
        view()->composer('*', function ($view) {
            $user = Auth::user();
            if ($user != null) {
                $view->with('user', Auth::user()->getBasicUserData());
            }
        });

        Cashier::useCurrency('eur', '€');
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
