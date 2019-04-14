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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'indicator'],function(){
   Route::any('upload','Indicator\ImageController@upload');
});

Route::any('login','Wechat\AuthController@getWxUserInfo');
Route::any('register','Wechat\AuthController@register');
Route::any('binding','Wechat\AuthController@binding');
Route::any('info','Wechat\AuthController@getUserInfo');
Route::any('change','Wechat\AuthController@changeUserInfo');
Route::any('upload','Wechat\IndicatorController@upload');
Route::any('ocr','Wechat\IndicatorController@OCR');
Route::any('save','Wechat\IndicatorController@saveImageDate');

Route::any('mail','MailController@mail');
