<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
 * Authentication routes
 */
Route::get('login', ['as' =>'auth/login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('login', ['as' =>'auth/login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('logout', ['as' => 'auth/logout', 'uses' => 'Auth\AuthController@getLogout']);

/*
 * Registration routes
 */
Route::get('register', ['as' => 'auth/register', 'uses' => 'Auth\AuthController@getRegister']);
Route::post('register', ['as' => 'auth/register', 'uses' => 'Auth\AuthController@postRegister']);

/*
 * Home routes
 */
Route::get('home', 'Home\HomeController@index');

Route::get('home/profile/{id?}', [
    'middleware' => 'auth',
    'uses' => 'UserController@edit'
])->where('id', '[0-9]+');

Route::post('home/profile/update/{id?}', [
    'middleware' => 'auth',
    'before' => 'csrf',
    'uses' => 'UserController@update'
])->where('id', '[0-9]+');;
