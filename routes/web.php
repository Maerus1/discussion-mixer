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

Route::get('/', 'DiscussionController@index')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('discussions', 'DiscussionController')->except([
    'destroy'
]);

Route::post('posts/{post_id}', 'PostController@store')->name('posts.store.');

Route::resource('posts', 'PostController')->except([
    'store',
    'index',
    'create',
    'show',
    'edit',
    'destroy'
]);

Route::resource('users', 'UserController')->except([
    'index',
    'create',
    'store',
    'destroy'
]);