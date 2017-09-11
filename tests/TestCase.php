<?php

namespace Tests;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Tests\Helpers\Response;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    use CreatesApplication;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * HTTP headers.
     *
     * @var array
     */
    protected $server = [];

    public function setUp()
    {
        parent::setUp();
        $this->createApplication();
        Artisan::call('migrate:reset');
        Artisan::call('migrate');
        Artisan::call('db:seed', array("--class" => "TestDatabaseSeeder"));
    }

    public function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }

    /**
     * Call the given URI and return the Response.
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  array  $parameters
     * @param  array  $cookies
     * @param  array  $files
     * @param  array  $server
     * @param  string  $content
     *
     * @return Response
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        $response = parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);

        return Response::fromTestResponse($response);
    }

    /**
     * Login as user for tests.
     *
     * Note: it is done this way because the method actingAs or be are not working.
     *
     * @param UserContract $user
     * @param null $driver
     */
    public function be(UserContract $user, $driver = null)
    {
        Auth::login($user);
    }
}
