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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about',function(){
    return 'This is all about...';
});
Route::get('/services','PagesController@services');

Route::get('/about/{name}',function($name){
    return "<center><h1>" .$name. " may be some stuff on earth.</h1></center>";
});
Route::get('/pages/{value1}/{value2}','PagesController@index');

Route::resource('posts','PostsController');

Route::get('/insta','Insta\InstaController@home');
Route::post('/insta/upload_profile', ['uses' => 'Insta\InstaController@upload_profile', 'as' => 'upload_profile']);
Route::post('/insta/upload_post','Insta\InstaController@upload_post');
Route::get('/insta/delete/{id}','Insta\InstaController@delete_post');
Route::post('/insta/post_comment','Insta\InstaController@post_comment');
Route::get('insta/{photo_id}/comments','Insta\InstaController@photo_comment');

Route::get('insta/{id}/friends', ['uses' => 'Insta\InstaController@friends', 'as' => 'friends']);
Route::get('insta/{id}/view_friends',['uses' => 'Insta\InstaController@view_friends','as' => 'view_friends']);
Route::get('insta/{id}/view_pendingRequest',['uses' => 'Insta\InstaController@view_pendingRequest', 'as' => 'view_pendingRequest']);
Route::get('insta/{id}/view_sentRequest',['uses' => 'Insta\InstaController@view_sentRequest', 'as' => 'view_sentRequest']);
Route::get('insta/{id}/view_people',['uses' => 'Insta\InstaController@view_people', 'as' => 'view_people']);
Route::post('insta/sendRequest','Insta\InstaController@sendRequest');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
