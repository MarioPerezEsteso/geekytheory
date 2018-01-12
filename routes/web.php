<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Patterns
Route::pattern('id', '\d+');
Route::pattern('token', '[a-z0-9]+');
Route::pattern('hex', '[a-f0-9]+');
Route::pattern('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
Route::pattern('base', '[a-zA-Z0-9]+');
Route::pattern('slug', '[a-z0-9-]+');
Route::pattern('username', '[a-zA-Z0-9]{3,20}');

Route::get('/', 'IndexController@index');

/*
 * Authentication routes
 */
Route::get('login', [
    'as' => 'login',
    'uses' => 'Auth\LoginController@showLoginForm',
]);

Route::post('login', [
    'as' => 'login',
    'uses' => 'Auth\LoginController@login'
]);

Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

/*
 * Registration routes
 */
Route::get('registro', [
    'as' => 'auth.register.get',
    'uses' => 'Auth\RegisterController@showRegistrationForm'
]);

Route::post('register', [
    'as' => 'auth.register.post',
    'uses' => 'Auth\RegisterController@register'
]);

/**
 * Password routes
 */
Route::get('password/reset', [
    'as' => 'password.request',
    'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
]);
Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset/{token?}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset']);

/**
 * Routes for courses
 */
Route::get('cursos', [
    'as' => 'courses',
    'uses' => 'CourseController@index',
]);

Route::get('curso/{slug}', [
    'as' => 'course',
    'uses' => 'CourseController@show',
]);

Route::get('curso/{courseSlug}/{lessonSlug}', [
    'as' => 'course.lesson',
    'uses' => 'LessonController@show',
]);

Route::post('curso/{id}/matriculacion', [
    'as' => 'course.join.post',
    'middleware' => 'auth',
    'uses' => 'CourseController@join',
]);

Route::post('lesson/complete', [
    'as' => 'lesson.complete',
    'middleware' => 'auth',
    'uses' => 'LessonController@complete',
]);

/**
 * Routes for account
 */
Route::get('cuenta', [
    'as' => 'account',
    'middleware' => 'auth',
    'uses' => 'AccountController@index',
]);

Route::get('cuenta/perfil', [
    'as' => 'account.profile',
    'middleware' => 'auth',
    'uses' => 'UserController@edit',
]);

Route::get('cuenta/perfil/contrasena', [
    'as' => 'account.profile.password',
    'middleware' => 'auth',
    'uses' => 'UserController@editPassword',
]);

Route::post('account/profile', [
    'as' => 'account.profile.post',
    'middleware' => 'auth',
    'uses' => 'UserController@update',
]);

Route::post('account/profile/password', [
    'as' => 'account.profile.password.post',
    'middleware' => 'auth',
    'uses' => 'UserController@updatePassword',
]);

Route::get('cuenta/suscripcion', [
    'as' => 'account.subscription',
    'middleware' => 'auth',
    'uses' => 'SubscriptionController@show',
]);

Route::post('account/subscription', [
    'as' => 'account.subscription.post',
    'middleware' => 'auth',
    'uses' => 'SubscriptionController@store',
]);

Route::post('account/subscription/cancel', [
    'as' => 'account.subscription.cancel',
    'middleware' => 'auth',
    'uses' => 'SubscriptionController@cancel',
]);

Route::get('cuenta/suscripcion/metodo-pago', [
    'as' => 'account.subscription.payment-method',
    'middleware' => 'auth',
    'uses' => 'SubscriptionController@showPaymentMethod',
]);

Route::post('account/subscription/card', [
    'as' => 'account.subscription.card.post',
    'middleware' => 'auth',
    'uses' => 'SubscriptionController@updateCard',
]);

Route::get('precios', [
    'as' => 'pricing',
    'uses' => 'IndexController@pricing',
]);

/*
 * Newsletter subscription routes
 */
Route::group(['prefix' => 'newsletter'], function () {
    Route::post('subscribe', 'SubscriberController@subscribe');
    Route::get('confirm/{token}', 'SubscriberController@confirmSubscription');
    Route::get('unsubscribe/{token}', 'SubscriberController@unsubscribe');
});

Route::post('comment/store', [
    'before' => 'csrf',
    'uses' => 'CommentController@store',
]);

Route::get('comment/getForm', [
    'before' => 'csrf',
    'uses' => 'CommentController@getForm',
]);

Route::get('feed', 'FeedController@feed');

Route::get('/{slug?}', 'ArticleController@show');

Route::post('share-article', [
    'before' => 'csrf',
    'uses' => 'ArticleController@updateShares'
]);

Route::get('/p/{slug?}', 'PageController@show');

Route::get('user/{username}', 'ArticleController@showByUsername');

Route::get('category/{slug}', 'CategoryController@showByCategory');

Route::get('tag/{slug}', 'TagController@showByTag');
