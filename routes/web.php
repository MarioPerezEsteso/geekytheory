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
    'as' =>'login',
    'uses' => 'Auth\LoginController@showLoginForm',
]);

Route::post('login', [
    'as' =>'login',
    'uses' => 'Auth\LoginController@login'
]);

Route::get('logout', ['as' => 'auth/logout', 'uses' => 'Auth\LoginController@logout']);

/*
 * Registration routes
 */
Route::get('registro', [
    'as'            => 'auth.register.get',
    'middleware'    => 'allow_user_registration',
    'uses'          => 'Auth\RegisterController@showRegistrationForm'
]);

Route::post('register', [
    'as'            => 'auth.register.post',
    'middleware'    => 'allow_user_registration',
    'uses'          => 'Auth\RegisterController@register'
]);

/**
 * Routes for courses
 */
Route::get('cursos', ['as' => 'courses', 'uses' => 'CourseController@index']);
Route::get('curso/{slug}', ['as' => 'course', 'uses' => 'CourseController@show']);
Route::get('curso/{courseSlug}/{lessonSlug}', ['as' => 'course.lesson', 'uses' => 'LessonController@show']);

/*
 * Newsletter subscription routes
 */
Route::group(['prefix' => 'newsletter'], function () {
    Route::post('subscribe', 'SubscriberController@subscribe');
    Route::get('confirm/{token}', 'SubscriberController@confirmSubscription');
    Route::get('unsubscribe/{token}', 'SubscriberController@unsubscribe');
});

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

Route::get('home/articles/create', [
    'middleware'    => 'auth',
    'uses'          => 'ArticleController@create'
]);

Route::get('home/articles/edit/{id?}', [
    'middleware'    => 'auth',
    'uses'          => 'ArticleController@edit'
]);

Route::post('home/articles/update/{id?}', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'ArticleController@update'
]);

Route::get('home/articles/{username?}', [
    'middleware'    => 'auth',
    'uses'          => 'ArticleController@indexHome'
]);

Route::post('home/articles/store', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'ArticleController@store'
]);

Route::get('home/articles/preview/{slug}', [
    'middleware'    => 'auth',
    'uses'          => 'ArticleController@preview'
]);

Route::get('home/pages/create', [
    'middleware'    => 'auth',
    'uses'          => 'PageController@create'
]);

Route::get('home/pages/edit/{id?}', [
    'middleware'    => 'auth',
    'uses'          => 'PageController@edit'
]);

Route::post('home/pages/update/{id}', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'PageController@update'
]);

Route::get('home/pages/{username?}', [
    'middleware'    => 'auth',
    'uses'          => 'PageController@indexHome'
]);

Route::post('home/pages/store', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'PageController@store'
]);

Route::get('home/pages/preview/{slug}', [
    'middleware'    => 'auth',
    'uses'          => 'PageController@preview'
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

Route::get('home/tags/delete/{id}', [
    'middleware'    => 'auth',
    'uses'          => 'TagController@destroy'
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

Route::get('home/categories/delete/{id}', [
    'middleware'    => 'auth',
    'uses'          => 'CategoryController@destroy'
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

Route::post('home/categories/delete-image', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'CategoryController@deleteImage',
]);

Route::get('home/galleries/{username?}', [
    'middleware'    => 'auth',
    'uses'          => 'GalleryController@indexHome',
]);

Route::post('home/gallery/store', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'GalleryController@store',
]);

Route::get('home/gallery/create', [
    'middleware'    => 'auth',
    'uses'          => 'GalleryController@create',
]);

Route::get('home/gallery/edit/{id}', [
    'middleware'    => 'auth',
    'uses'          => 'GalleryController@edit',
]);

Route::post('home/gallery/update/{id}', [
    'middleware'    => 'auth',
    'uses'          => 'GalleryController@update',
]);

Route::post('home/gallery/image/delete', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'ImageController@deleteImageFromGallery',
]);

Route::get('home/articles/imagemanager/upload', [
    'middleware'    => 'auth',
    'uses'          => 'ImageManagerController@create'
]);

Route::get('home/articles/edit/imagemanager/upload', [
    'middleware'    => 'auth',
    'uses'          => 'ImageManagerController@create'
]);

Route::get('home/pages/imagemanager/upload', [
    'middleware'    => 'auth',
    'uses'          => 'ImageManagerController@create'
]);

Route::get('home/pages/edit/imagemanager/upload', [
    'middleware'    => 'auth',
    'uses'          => 'ImageManagerController@create'
]);

Route::post('home/posts/delete-image', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'PostController@deletePostImage',
]);

Route::post('home/imagemanager/upload', [
    'middleware'    => 'auth',
    'uses'          => 'ImageManagerController@store',
]);

Route::get('home/sitemeta', [
    'middleware'    => 'auth',
    'uses'          => 'SiteMetaController@edit',
]);

Route::post('home/sitemeta/update', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'SiteMetaController@update',
]);

Route::post('home/sitemeta/delete-image', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'SiteMetaController@deleteImage',
]);

Route::get('home/menu', [
    'middleware'    => 'auth',
    'uses'          => 'SiteMetaController@editMenu',
]);

Route::post('home/menu/update', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'SiteMetaController@updateMenu',
]);

Route::get('home/menu/getNewMenuItemHtml', [
    'middleware'    => 'auth',
    'before'        => 'csrf',
    'uses'          => 'SiteMetaController@getNewMenuItemHtml',
]);

Route::post('comment/store', [
    'before'        => 'csrf',
    'uses'          => 'CommentController@store',
]);

Route::get('comment/getForm', [
    'before'        => 'csrf',
    'uses'          => 'CommentController@getForm',
]);

Route::get('feed', 'FeedController@feed');

Route::get('/{slug?}', 'ArticleController@show');

Route::post('share-article', [
    'before'        => 'csrf',
    'uses'			=> 'ArticleController@updateShares'
]);

Route::get('/p/{slug?}', 'PageController@show');

Route::get('user/{username}', 'ArticleController@showByUsername');

Route::get('category/{slug}', 'CategoryController@showByCategory');

Route::get('tag/{slug}', 'TagController@showByTag');
