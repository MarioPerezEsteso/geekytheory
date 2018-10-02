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

Route::get('/', [
    'as' => 'home',
    'uses' => 'IndexController@index'
]);

/**
 * Redirects
 */
Route::get('introduccion-a-python-instalacion-y-hola-mundo', 'RedirectionController@redirect');
Route::get('introduccion-a-python-instalacion-y-hola-mundo', 'RedirectionController@redirect');
Route::get('operadores-y-tipos-en-python', 'RedirectionController@redirect');
Route::get('variables-en-python', 'RedirectionController@redirect');
Route::get('definicion-funciones-python', 'RedirectionController@redirect');
Route::get('bucles-en-python', 'RedirectionController@redirect');
Route::get('la-funcion-range-en-python', 'RedirectionController@redirect');
Route::get('como-crear-una-lista-de-tareas-con-laravel-tutorial-php', 'RedirectionController@redirect');
Route::get('tutorial-vagrant-1-que-es-y-como-usarlo', 'RedirectionController@redirect');
Route::get('json-i-que-es-y-para-que-sirve-json', 'RedirectionController@redirect');
Route::get('tutorial-0-introduccion-a-java-y-netbeans', 'RedirectionController@redirect');
Route::get('tutorial-1-java-hola-mundo', 'RedirectionController@redirect');
Route::get('tutorial-2-java-estructuras-secuenciales', 'RedirectionController@redirect');
Route::get('tutorial-3-java-estructuras-condicionales-y-excepciones', 'RedirectionController@redirect');
Route::get('tutorial-4-bucles', 'RedirectionController@redirect');
Route::get('tutorial-5-java-cadenas-de-caracteres', 'RedirectionController@redirect');
Route::get('tutorial-6-java-definicion-de-clases-y-objetos', 'RedirectionController@redirect');
Route::get('tutorial-7-java-vectores', 'RedirectionController@redirect');
Route::get('tutorial-8-java-vectores-parte-2', 'RedirectionController@redirect');
Route::get('tutorial-9-java-vectores-parte-3', 'RedirectionController@redirect');
Route::get('tutorial-10-java-matrices', 'RedirectionController@redirect');
Route::get('tutorial-11-java-constructor-de-la-clase', 'RedirectionController@redirect');
Route::get('tutorial-12-java-uso-de-varias-clases', 'RedirectionController@redirect');
Route::get('tutorial-13-java-herencia', 'RedirectionController@redirect');

Route::get('blog', [
    'as' => 'blog',
    'uses' => 'ArticleController@index',
]);

Route::get('contacto', [
    'as' => 'contact',
    'uses' => 'ContactFormController@show',
]);

Route::post('contacto', [
    'as' => 'contact.post',
    'before' => 'csrf',
    'uses' => 'ContactFormController@contact',
]);

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

Route::post('lesson/start', [
    'as' => 'lesson.start',
    'middleware' => 'auth',
    'uses' => 'LessonController@start',
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

Route::get('suscripcion', [
    'as' => 'subscription.create',
    'uses' => 'SubscriptionController@create',
]);

Route::get('cuenta/suscripcion', [
    'as' => 'account.subscription',
    'middleware' => 'auth',
    'uses' => 'SubscriptionController@show',
]);

Route::post('account/subscription', [
    'as' => 'account.subscription.post',
//    'middleware' => 'auth',
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

Route::post('coupon/validate', [
    'as' => 'coupon.validate',
    'middleware' => 'auth',
    'uses' => 'CouponController@checkCoupon',
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

Route::get('/{slug?}', [
    'as' => 'article',
    'uses' => 'ArticleController@show',
]);

Route::post('share-article', [
    'before' => 'csrf',
    'uses' => 'ArticleController@updateShares'
]);

Route::get('/p/{slug?}', 'PageController@show');

Route::get('user/{username}', [
    'as' => 'posts-user',
    'uses' => 'ArticleController@showByUsername',
]);

Route::get('category/{slug}', [
    'as' => 'post-category',
    'uses' => 'CategoryController@showByCategory',
]);

Route::get('tag/{slug}', 'TagController@showByTag');
