<?php

namespace App\Providers;

use Dingo\Api\Contract\Auth\Provider;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Route;
use Illuminate\Contracts\Auth\Factory as Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Class PassportAuthenticationProvider
 * @package App\Auth
 */
class PassportAuthenticationServiceProvider implements Provider
{
    /**
     * @var Auth
     */
    protected $auth;

    /**
     * PassportAuthenticationServiceProvider constructor.
     *
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return mixed
     */
    public function authenticate(Request $request, Route $route)
    {
        if ($this->auth->guard('api')->check()) {
            $this->auth->shouldUse('api');

            return $this->auth->guard('api')->user();
        }

        throw new UnauthorizedHttpException('Unable to authenticate.');
    }
}