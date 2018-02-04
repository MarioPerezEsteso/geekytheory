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
    'uses' => 'ArticleController@create'
]);

Route::get('home/articles/edit/{id?}', [
    'uses' => 'ArticleController@edit'
]);

Route::post('home/articles/update/{id?}', [
    'before' => 'csrf',
    'uses' => 'ArticleController@update'
]);

Route::get('home/articles/{username?}', [
    'uses' => 'ArticleController@indexHome'
]);

Route::post('home/articles/store', [
    'before' => 'csrf',
    'uses' => 'ArticleController@store'
]);

Route::get('home/articles/preview/{slug}', [
    'uses' => 'ArticleController@preview'
]);

Route::get('home/pages/create', [
    'uses' => 'PageController@create'
]);

Route::get('home/pages/edit/{id?}', [
    'uses' => 'PageController@edit'
]);

Route::post('home/pages/update/{id}', [
    'before' => 'csrf',
    'uses' => 'PageController@update'
]);

Route::get('home/pages/{username?}', [
    'uses' => 'PageController@indexHome'
]);

Route::post('home/pages/store', [
    'before' => 'csrf',
    'uses' => 'PageController@store'
]);

Route::get('home/pages/preview/{slug}', [
    'uses' => 'PageController@preview'
]);

Route::get('home/posts/delete/{id}', [
    'uses' => 'PostController@delete'
]);

Route::get('home/posts/restore/{id}', [
    'uses' => 'PostController@restore'
]);

Route::get('home/tags', [
    'uses' => 'TagController@create'
]);

Route::get('home/tags/edit/{id}', [
    'uses' => 'TagController@edit'
]);

Route::get('home/tags/delete/{id}', [
    'uses' => 'TagController@destroy'
]);

Route::post('home/tags/store', [
    'before' => 'csrf',
    'uses' => 'TagController@store'
]);

Route::post('home/tags/update/{id}', [
    'before' => 'csrf',
    'uses' => 'TagController@update'
]);

Route::get('home/categories', [
    'uses' => 'CategoryController@create'
]);

Route::get('home/categories/edit/{id}', [
    'uses' => 'CategoryController@edit'
]);

Route::get('home/categories/delete/{id}', [
    'uses' => 'CategoryController@destroy'
]);

Route::post('home/categories/store', [
    'before' => 'csrf',
    'uses' => 'CategoryController@store'
]);

Route::post('home/categories/update/{id}', [
    'before' => 'csrf',
    'uses' => 'CategoryController@update'
]);

Route::post('home/categories/delete-image', [
    'before' => 'csrf',
    'uses' => 'CategoryController@deleteImage',
]);

Route::get('home/articles/imagemanager/upload', [
    'uses' => 'ImageManagerController@create'
]);

Route::get('home/articles/edit/imagemanager/upload', [
    'uses' => 'ImageManagerController@create'
]);

Route::get('home/pages/imagemanager/upload', [
    'uses' => 'ImageManagerController@create'
]);

Route::get('home/pages/edit/imagemanager/upload', [
    'uses' => 'ImageManagerController@create'
]);

Route::post('home/posts/delete-image', [
    'before' => 'csrf',
    'uses' => 'PostController@deletePostImage',
]);

Route::post('home/imagemanager/upload', [
    'uses' => 'ImageManagerController@store',
]);

Route::get('home/sitemeta', [
    'uses' => 'SiteMetaController@edit',
]);

Route::post('home/sitemeta/update', [
    'before' => 'csrf',
    'uses' => 'SiteMetaController@update',
]);

Route::post('home/sitemeta/delete-image', [
    'before' => 'csrf',
    'uses' => 'SiteMetaController@deleteImage',
]);

Route::get('home/menu', [
    'uses' => 'SiteMetaController@editMenu',
]);

Route::post('home/menu/update', [
    'before' => 'csrf',
    'uses' => 'SiteMetaController@updateMenu',
]);

Route::get('home/menu/getNewMenuItemHtml', [
    'before' => 'csrf',
    'uses' => 'SiteMetaController@getNewMenuItemHtml',
]);
