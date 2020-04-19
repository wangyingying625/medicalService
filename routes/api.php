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
Route::namespace('Api')->prefix('v1')->middleware('cors')->group(function () {
    Route::post('/register','UserController@store')->name('users.store');
    Route::get('/users','UserController@index')->name('users.index');
    Route::get('/users/info','UserController@info')->name('users.info');
    Route::get('/users/{user}','UserController@show')->name('users.show');
    Route::post('/login','UserController@login')->name('users.login');
    Route::post('/edit','UserController@edit')->name('users.edit');


});
Route::namespace('Api')->prefix('family')->middleware('cors')->group(function () {
    Route::get('/newFamily','FamilyController@createFamily')->name('family.createFamily');
    Route::get('/familyList','FamilyController@showMembers')->name('family.createFamily');
    Route::get('/join','FamilyController@apply')->name('family.apply');
    Route::get('/accept','FamilyController@accept')->name('family.accept');
    Route::get('/refuse','FamilyController@refuse')->name('family.refuse');
    Route::get('/applyList','FamilyController@applyList')->name('family.applyList');
    Route::get('/quitFamily','FamilyController@quitFamily')->name('family.quit');
    Route::get('/disband','FamilyController@dissolveFamily')->name('family.disband');
    Route::get('/delete','FamilyController@del')->name('family.delete');

});
Route::namespace('Api')->prefix('upload')->middleware('cors')->group(function () {
    Route::post('/uploadPicture','UploadController@upload')->name('upload.uploadPicture');
    Route::post('/identify','UploadController@OCR')->name('upload.identify');
    Route::get('/record','UploadController@showIndicator')->name('upload.record');
    Route::get('/getTemp','UploadController@getTemplate')->name('upload.getTemplate');

});
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
Route::any('detail/{IndicatorName}','WarningController@getDetailByName');
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