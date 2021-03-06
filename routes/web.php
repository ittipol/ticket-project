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

// Route::get('/teste', function(){
//   // dd(App\library\url::url('/'));

//   $id = Redis::get('user-online:2');
//   Redis::del('user-online:2');

//   Redis::set('999--val',1);
//   Redis::expire('test--val', 7200);

//   dd('del: '.$id);
// });

// Route::get('/teste', 'HomeController@_checkPost');

Route::get('/', 'TicketController@listView');
Route::get('features', 'HomeController@index');
// Route::get('about', 'HomeController@about');
// Route::get('policy', 'HomeController@policy');

Route::get('avatar/{userId?}/{filename?}', 'StaticFileController@userAvatar');
Route::get('get_image/{filename}', 'StaticFileController@serveImages');

Route::get('ticket', 'TicketController@listView');
Route::get('ticket/view/{ticketId}', 'TicketController@detail');

Route::get('ticket-list', 'TicketController@_list');

// Route::get('hashtag/{hashTag}', 'HashtagController@index');

Route::group(['middleware' => 'guest'], function () {
  Route::get('login', array('as' => 'login', 'uses' => 'UserController@login'));
  Route::post('login', 'UserController@authenticate');

  Route::get('facebook/login', 'UserController@socialCallback');

  Route::get('subscribe', 'UserController@register');
  Route::post('subscribe', 'UserController@registering');
});

Route::group(['middleware' => 'auth'], function () {

  Route::get('account', 'AccountController@profile');

  Route::get('account/edit', 'AccountController@edit');
  Route::patch('account/edit', 'AccountController@profileEditingSubmit');

  Route::get('account/ticket', 'AccountController@ticket');

  Route::get('logout', 'UserController@logout');

  Route::get('ticket/new', 'TicketController@add');
  Route::post('ticket/new', 'TicketController@addingSubmit');

  Route::get('ticket/edit/{ticketId}', 'TicketController@edit');
  Route::patch('ticket/edit/{ticketId}', 'TicketController@editingSubmit');

  Route::post('ticket/close', 'TicketController@close');

  Route::get('ticket/pull/{ticketId}', 'TicketController@pullPost');

  Route::get('chat/s/{ticketId}', 'ChatController@sellerChat'); // s = seller
  // Route::get('chat/b/{ticketId}', 'ChatController@buyerChat'); // b = buyer
  Route::get('chat/r/{roomId}', 'ChatController@chatRoom'); // r = room

  Route::post('upload/image', 'ImageController@upload');

});