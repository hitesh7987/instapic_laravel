<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register','API\UserController@register');
Route::post('login','API\UserController@login');
Route::post('details','API\UserController@details')->middleware(['auth:api']);
Route::group(['middleware'=>'auth:api'],function(){
 Route::get('details','API\UserController@details');
 Route::post('logout','API\UserController@logout');
 Route::get('posts','Api\Usercontroller@posts');
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
