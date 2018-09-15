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

Route::get('/', 'PagesController@root')->name('root');

Auth::routes();

Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'update', 'edit']]);

Route::get('/users/editavatar/{user}', 'UsersController@editAvatar')->name('users.editavatar');
Route::get('/users/avatar/{user}', 'UsersController@generator')->name('users.avatar');
Route::post('/users/editavatar/{user}', 'UsersController@saveAvatar')->name('users.editavatar');
Route::get('/users/{user}/followings', 'UsersController@followings')->name('users.followings');
Route::get('/users/{user}/followers', 'UsersController@followers')->name('users.followers');

// 关注
Route::post('/users/followers/{user}', 'FollowersController@store')->name('followers.store');
Route::delete('/users/followers/{user}', 'FollowersController@destroy')->name('followers.destroy');

Route::resource('topics', 'TopicsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
// 删除话题的标签
Route::post('topics/deletetag/{topic}', 'TopicsController@deleteTag')->name('topics.deletetag');
// 获取话题下的回复

Route::get('topics/comments/{topic}', 'TopicsController@getComments')->name('topics.getcomments');

Route::resource('tags', 'TagsController', ['only' => [ 'show' ]]);

// 新建一份历史档案
Route::get('topic_edit/{topic}/create', 'TopicEditController@create')->name('topic_edit.create');
// 审核一份文档

Route::get('topic_edit/{topic}/check/{topic_edit}/{type?}', 'TopicEditController@check')->name('topic_edit.check');

// show 方法显示档案的审核和预览

Route::resource('topic_edit', 'TopicEditController', ['only' => [ 'index', 'edit', 'store', 'update', 'show' ]]);
// 图片上传地址

Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');
Route::resource('replies', 'RepliesController', ['only' => [ 'store', 'destroy']]);

Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');

Route::get('crsf_token', function () {
	return ['token' => csrf_token()];
});