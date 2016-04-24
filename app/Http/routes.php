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

// Patterns
Route::pattern('id', '\d+');
Route::pattern('hash', '[a-z0-9]+');
Route::pattern('hex', '[a-f0-9]+');
Route::pattern('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
Route::pattern('base', '[a-zA-Z0-9]+');
Route::pattern('slug', '[a-z0-9-]+');
Route::pattern('username', '[a-z0-9_-]{3,20}');

Route::get('/', 'IndexController@index');

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
    'middleware'    => 'auth',
    'uses'          => 'UserController@edit'
]);

Route::post('home/profile/update/{id?}', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'UserController@update'
]);

Route::get('home/posts/create', [
    'middleware'    => 'auth',
    'uses'          => 'PostController@create'
]);

Route::get('home/posts/edit/{id?}', [
    'middleware'    => 'auth',
    'uses'          => 'PostController@edit'
]);

Route::post('home/posts/update/{id?}', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'PostController@update'
]);

Route::get('home/posts/{username?}', [
    'middleware'    => 'auth',
    'uses'          => 'PostController@indexHome'
]);

Route::post('home/posts/store', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'PostController@store'
]);

Route::get('home/posts/delete/{id}', [
    'middleware'    => 'auth',
    'uses'          => 'PostController@delete'
]);

Route::get('home/posts/restore/{id}', [
    'middleware'    => 'auth',
    'uses'          => 'PostController@restore'
]);

Route::get('home/tags', [
    'middleware'    => 'auth',
    'uses'          => 'TagController@create'
]);

Route::get('home/tags/edit/{id}', [
    'middleware'    => 'auth',
    'uses'          => 'TagController@edit'
]);

Route::post('home/tags/store', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'TagController@store'
]);

Route::post('home/tags/update/{id}', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'TagController@update'
]);

Route::get('home/categories', [
    'middleware'    => 'auth',
    'uses'          => 'CategoryController@create'
]);

Route::get('home/categories/edit/{id}', [
    'middleware'    => 'auth',
    'uses'          => 'CategoryController@edit'
]);

Route::post('home/categories/store', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'CategoryController@store'
]);

Route::post('home/categories/update/{id}', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'CategoryController@update'
]);

Route::get('home/posts/imagemanager/upload', [
    'middleware'    => 'auth',
    'uses'          => 'ImageManagerController@create'
]);

Route::get('home/posts/edit/imagemanager/upload', [
    'middleware'    => 'auth',
    'uses'          => 'ImageManagerController@create'
]);

Route::post('home/imagemanager/upload', [
    'middleware'    => 'auth',
    'uses'          => 'ImageManagerController@store'
]);

Route::group(array('prefix' => 'api'), function () {
   Route::resource('posts', 'PostController');
});