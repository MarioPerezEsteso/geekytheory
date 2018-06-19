<?php

namespace Tests;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\Helpers\Response;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    use CreatesApplication;

    /**
     * Variable to check if database is migrated
     *
     * @var bool
     */
    protected static $databaseMigrated = false;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://geekytheory.dev';

    /**
     * @var string
     */
    protected $loginUrl = '/login';

    /**
     * @var string
     */
    protected $registrationUrl = '/registro';

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

        if (env('RESET_DATABASE_TEST', "1") === "1" && !static::$databaseMigrated) {
            Artisan::call('migrate:reset');
            Artisan::call('migrate');
            Artisan::call('db:seed', array("--class" => "TestDatabaseSeeder"));
            static::$databaseMigrated = true;
        }
    }

    public function tearDown()
    {
        $this->beforeApplicationDestroyed(function () {
            \DB::disconnect();
        });

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
     * Act as a user for tests calls.
     *
     * @param UserContract $user
     * @param null $driver
     *
     * @return TestCase
     */
    public function actingAs(UserContract $user, $driver = null)
    {
        Auth::login($user);
        return parent::actingAs($user, $driver);
    }

    /**
     * Get URL with base URL.
     *
     * @param string $url
     * @return string
     */
    public function getUrlWithBase($url)
    {
        return $this->baseUrl . $url;
    }
}
