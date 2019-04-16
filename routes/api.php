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
Route::any('days','Wechat\IndicatorController@checkTime');
Route::any('save','Wechat\IndicatorController@saveImageDate');
Route::get('show/user','Wechat\IndicatorController@showIndicatorByOpenId');
Route::get('show/userid','Wechat\IndicatorController@showIndicatorByUserId');

Route::any('mail','MailController@mail');
Route::group(['prefix'=>'family'],function() {
    Route::any('create','Wechat\FamilyController@createFamily');
    Route::any('info','Wechat\FamilyController@showMembers');
    Route::any('dissolve','Wechat\FamilyController@dissolveFamily');
    Route::any('apply','Wechat\FamilyController@apply');
    Route::any('quit','Wechat\FamilyController@quit');
    Route::any('manage','Wechat\FamilyController@manage');
    Route::any('accept','Wechat\FamilyController@accept');
    Route::any('no','Wechat\FamilyController@del');

});