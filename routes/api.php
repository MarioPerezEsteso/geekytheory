<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->post('academia/login', 'App\Http\Controllers\Auth\LoginController@apiLogin');

    $api->group(['middleware' => ['api.auth']], function ($api) {
        $api->get('courses', function () {
            return \App\User::all();
        });
    });
});
