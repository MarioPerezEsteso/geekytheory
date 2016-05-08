<?php

namespace App\Http\Middleware;

use App\Http\Controllers\SiteMetaController;
use Closure;

class AllowUserRegistration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (SiteMetaController::getSiteMeta()->getAttribute('allow_register')) {
            return $next($request);
        }
        abort(404);
    }
}
