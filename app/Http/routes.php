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

/**
* Home
*/

Route::get('/', ['uses' => 'HomeController@index','as'   => 'home',]);

/**
* Authentication
*/

Route::get('/signup', ['uses' => 'AuthController@getSignup', 'as'   => 'auth.signup', 'middleware' => ['guest'],]);

Route::post('/signup', ['uses' => 'AuthController@postSignup', 'middleware' => ['guest'],]);

Route::get('/signin', ['uses' => 'AuthController@getSignin', 'as'   => 'auth.signin', 'middleware' => ['guest'],]);

Route::post('/signin', ['uses' => 'AuthController@postSignin','middleware' => ['guest'],]);

Route::get('/signout', [ 'uses' => 'AuthController@getSignout',  'as'   => 'auth.signout',]);


/**
* Search
*/

Route::get('/search', ['uses' => 'SearchController@getResults',  'as'   => 'search.results',  'middleware' => ['auth'],]);

/**
* User profile
*/

Route::get('/user/{username}', ['uses' => 'ProfileController@getProfile',  'as'   => 'profile.index',  'middleware' => ['auth'],]);

Route::get('/profile/edit', ['uses' => 'ProfileController@getEdit',  'as'   => 'profile.edit',  'middleware' => ['auth'],]);

Route::post('/profile/edit', ['uses' => 'ProfileController@postEdit',  'middleware' => ['auth'],]);

/**
* Friends
*/
Route::get('/friends', ['uses' => 'FriendController@getIndex',  'as'   => 'friend.index',  'middleware' => ['auth'],]);

Route::get('/friends/add/{username}', ['uses' => 'FriendController@getAdd',  'as'   => 'friend.add',  'middleware' => ['auth'],]);

Route::get('/friends/accept/{username}', ['uses' => 'FriendController@getAccept',  'as'   => 'friend.accept',  'middleware' => ['auth'],]);

Route::post('/friends/delete/{username}', ['uses' => 'FriendController@postDelete',  'as'   => 'friend.delete',  'middleware' => ['auth'],]);

/**
* Statuses
*/

Route::post('/status', ['uses' => 'StatusController@postStatus',  'as'   => 'status.post',  'middleware' => ['auth'],]);

Route::post('/status/{statusId}/reply', ['uses' => 'StatusController@postReply',  'as'   => 'status.reply',  'middleware' => ['auth'],]);

Route::get('/status/{statusId}/like', ['uses' => 'StatusController@getLike',  'as'   => 'status.like',  'middleware' => ['auth'],]);
