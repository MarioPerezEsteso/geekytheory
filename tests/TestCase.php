<?php

namespace Tests;

use App\User;
use Illuminate\Support\Facades\Artisan;
use Tests\Helpers\Response;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
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

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

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
     * Set HTTP header with authorization to log a user in.
     *
     * @param User $user
     */
    public function loginWithTokenAs(User $user)
    {
        $token = $user->createToken('AccessToken', [])->accessToken;
        $this->server = ['HTTP_Authorization' => 'Bearer ' . $token];
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
        $server = array_merge($this->server, $server);
        $response = parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);

        return Response::fromTestResponse($response);
    }
}
