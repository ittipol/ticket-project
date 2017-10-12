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

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
// Route::get('about', 'HomeController@about');

Route::get('avatar/{filename?}', 'StaticFileController@userAvatar');
Route::get('get_image/{filename}', 'StaticFileController@serveImages');

Route::get('ticket', 'TicketController@listView');
Route::get('ticket/view/{ticketId}', 'TicketController@detail');

Route::group(['middleware' => 'guest'], function () {
  Route::get('login', array('as' => 'login', 'uses' => 'UserController@login'));
  Route::post('login', 'UserController@authenticate');

  Route::get('facebook/login', 'UserController@socialCallback');

  Route::get('subscribe', 'UserController@register');
  Route::post('subscribe', 'UserController@registering');
});

Route::group(['middleware' => 'auth'], function () {

  Route::get('logout', 'UserController@logout');

  Route::get('ticket/new', 'TicketController@add');
  Route::post('ticket/new', 'TicketController@addingSubmit');

  Route::get('chat/{ticketId}', 'UserController@chat');

  Route::post('upload/image', 'ImageController@upload');

});