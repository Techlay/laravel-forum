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

Route::get('', 'ThreadController@index');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('threads', 'ThreadController@index')->name('threads');
Route::get('threads/search', 'SearchController@show')->name('search.show');
Route::get('threads/{channel}/{thread}', 'ThreadController@show')->name('threads.show');
Route::patch('threads/{channel}/{thread}', 'ThreadController@update')->name('threads.update');
Route::delete('threads/{channel}/{thread}', 'ThreadController@destroy')->name('threads.destroy');
Route::post('threads', 'ThreadController@store')->middleware('verified')->name('threads.store');
Route::get('threads/{channel}', 'ThreadController@index')->name('channels');

Route::post('locked-threads/{thread}', 'LockedThreadController@store')->middleware('admin')->name('locked-threads.store');
Route::delete('locked-threads/{thread}', 'LockedThreadController@destroy')->middleware('admin')->name('locked-threads.destroy');

Route::post('pinned-threads/{thread}', 'PinnedThreadController@store')->middleware('admin')->name('pinned-threads.store');
Route::delete('pinned-threads/{thread}', 'PinnedThreadController@destroy')->middleware('admin')->name('pinned-threads.destroy');

Route::get('threads/{channel}/{thread}/replies', 'ReplyController@index')->name('replies');
Route::post('threads/{channel}/{thread}/replies', 'ReplyController@store')->middleware('verified')->name('replies.store');
Route::patch('replies/{reply}', 'ReplyController@update')->name('replies.update');
Route::delete('replies/{reply}', 'ReplyController@destroy')->name('replies.destroy');

Route::post('replies/{reply}/best', 'BestReplyController@store')->name('best-replies.store');

Route::post('threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@store')->middleware('auth');
Route::delete('threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@destroy')->middleware('auth');

Route::post('replies/{reply}/favorites', 'FavoriteController@store')->name('replies.favorite');
Route::delete('replies/{reply}/favorites', 'FavoriteController@destroy')->name('replies.unfavorite');

Route::get('profiles/{user}', 'ProfileController@show')->name('profile');
Route::get('profiles/{user}/activity', 'ProfileController@index')->name('activity');
Route::get('profiles/{user}/notifications', 'UserNotificationController@index')->name('user-notifications');
Route::delete('profiles/{user}/notifications/{notification}', 'UserNotificationController@destroy')->name('user-notification.destroy');

Route::get('api/users', 'Api\UserController@index')->name('api.users');
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');
Route::get('api/channels', 'Api\ChannelController@index');

Route::group([
    'prefix' => 'admin',
    'middleware' => 'admin',
    'namespace' => 'Admin'
], function () {
    Route::get('', 'DashboardController@index')->name('admin.dashboard.index');
    Route::post('channels', 'ChannelController@store')->name('admin.channels.store');
    Route::get('channels', 'ChannelController@index')->name('admin.channels.index');
    Route::get('channels/create', 'ChannelController@create')->name('admin.channels.create');
    Route::get('channels/{channel}/edit', 'ChannelController@edit')->name('admin.channels.edit');
    Route::patch('channels/{channel}', 'ChannelController@update')->name('admin.channels.update');
});
