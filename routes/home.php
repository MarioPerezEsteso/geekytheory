<?php

/*
|--------------------------------------------------------------------------
| Home Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web-admin" middleware group.
|
*/

/*
* Home routes
*/
Route::get('home', 'Home\HomeController@index');

Route::get('home/articles/create', [
    'middleware' => 'auth',
    'uses' => 'ArticleController@create'
]);

Route::get('home/articles/edit/{id?}', [
    'middleware' => 'auth',
    'uses' => 'ArticleController@edit'
]);

Route::post('home/articles/update/{id?}', [
    'middleware' => 'auth',
    'before' => 'csrf',
    'uses' => 'ArticleController@update'
]);

Route::get('home/articles/{username?}', [
    'middleware' => 'auth',
    'uses' => 'ArticleController@indexHome'
]);

Route::post('home/articles/store', [
    'middleware' => 'auth',
    'before' => 'csrf',
    'uses' => 'ArticleController@store'
]);

Route::get('home/articles/preview/{slug}', [
    'middleware' => 'auth',
    'uses' => 'ArticleController@preview'
]);

Route::get('home/pages/create', [
    'middleware' => 'auth',
    'uses' => 'PageController@create'
]);

Route::get('home/pages/edit/{id?}', [
    'middleware' => 'auth',
    'uses' => 'PageController@edit'
]);

Route::post('home/pages/update/{id}', [
    'middleware' => 'auth',
    'before' => 'csrf',
    'uses' => 'PageController@update'
]);

Route::get('home/pages/{username?}', [
    'middleware' => 'auth',
    'uses' => 'PageController@indexHome'
]);

Route::post('home/pages/store', [
    'middleware' => 'auth',
    'before' => 'csrf',
    'uses' => 'PageController@store'
]);

Route::get('home/pages/preview/{slug}', [
    'middleware' => 'auth',
    'uses' => 'PageController@preview'
]);

Route::get('home/posts/delete/{id}', [
    'middleware' => 'auth',
    'uses' => 'PostController@delete'
]);

Route::get('home/posts/restore/{id}', [
    'middleware' => 'auth',
    'uses' => 'PostController@restore'
]);

Route::get('home/tags', [
    'middleware' => 'auth',
    'uses' => 'TagController@create'
]);

Route::get('home/tags/edit/{id}', [
    'middleware' => 'auth',
    'uses' => 'TagController@edit'
]);

Route::get('home/tags/delete/{id}', [
    'middleware' => 'auth',
    'uses' => 'TagController@destroy'
]);

Route::post('home/tags/store', [
    'middleware' => 'auth',
    'before' => 'csrf',
    'uses' => 'TagController@store'
]);

Route::post('home/tags/update/{id}', [
    'middleware' => 'auth',
    'before' => 'csrf',
    'uses' => 'TagController@update'
]);

Route::get('home/categories', [
    'middleware' => 'auth',
    'uses' => 'CategoryController@create'
]);

Route::get('home/categories/edit/{id}', [
    'middleware' => 'auth',
    'uses' => 'CategoryController@edit'
]);

Route::get('home/categories/delete/{id}', [
    'middleware' => 'auth',
    'uses' => 'CategoryController@destroy'
]);

Route::post('home/categories/store', [
    'middleware' => 'auth',
    'before' => 'csrf',
    'uses' => 'CategoryController@store'
]);

Route::post('home/categories/update/{id}', [
    'middleware' => 'auth',
    'before' => 'csrf',
    'uses' => 'CategoryController@update'
]);

Route::post('home/categories/delete-image', [
    'middleware' => 'auth',
    'before' => 'csrf',
    'uses' => 'CategoryController@deleteImage',
]);

Route::get('home/articles/imagemanager/upload', [
    'middleware' => 'auth',
    'uses' => 'ImageManagerController@create'
]);

Route::get('home/articles/edit/imagemanager/upload', [
    'middleware' => 'auth',
    'uses' => 'ImageManagerController@create'
]);

Route::get('home/pages/imagemanager/upload', [
    'middleware' => 'auth',
    'uses' => 'ImageManagerController@create'
]);

Route::get('home/pages/edit/imagemanager/upload', [
    'middleware' => 'auth',
    'uses' => 'ImageManagerController@create'
]);

Route::post('home/posts/delete-image', [
    'middleware' => 'auth',
    'before' => 'csrf',
    'uses' => 'PostController@deletePostImage',
]);

Route::post('home/imagemanager/upload', [
    'middleware' => 'auth',
    'uses' => 'ImageManagerController@store',
]);

Route::get('home/sitemeta', [
    'middleware' => 'auth',
    'uses' => 'SiteMetaController@edit',
]);

Route::post('home/sitemeta/update', [
    'middleware' => 'auth',
    'before' => 'csrf',
    'uses' => 'SiteMetaController@update',
]);

Route::post('home/sitemeta/delete-image', [
    'middleware' => 'auth',
    'before' => 'csrf',
    'uses' => 'SiteMetaController@deleteImage',
]);

Route::get('home/menu', [
    'middleware' => 'auth',
    'uses' => 'SiteMetaController@editMenu',
]);

Route::post('home/menu/update', [
    'middleware' => 'auth',
    'before' => 'csrf',
    'uses' => 'SiteMetaController@updateMenu',
]);

Route::get('home/menu/getNewMenuItemHtml', [
    'middleware' => 'auth',
    'before' => 'csrf',
    'uses' => 'SiteMetaController@getNewMenuItemHtml',
]);
