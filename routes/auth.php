<?php

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Login routes
 */
Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);

Route::post('login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);

Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

/*
 * Registration routes
 */
Route::get('registro', ['as' => 'auth.register.get', 'uses' => 'Auth\RegisterController@showRegistrationForm']);

Route::post('register', ['as' => 'auth.register.post', 'uses' => 'Auth\RegisterController@register']);

Route::get('registro/suscripcion', ['as' => 'auth.register.subscription.get', 'uses' => 'Auth\RegisterController@showRegistrationWithSubscriptionForm']);

Route::post('registro/subscripcion', ['as' => 'auth.register.subscription.post', 'uses' => 'Auth\RegisterController@register']);

/**
 * Password routes
 */
Route::get('password/reset', ['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);

Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);

Route::get('password/reset/{token?}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);

Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset']);
