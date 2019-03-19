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
    return view('index');
});
//Route::get('/record', function () {
//    return view('record');
//});
//Route::get('/pictures', function () {
//    return view('pictures');
//});
//Route::get('/familyAdd', function () {
//    return view('familyAdd');
//})->middleware('auth');
//Route::get('/geRen', function () {
//    return view('geRen');
//});

Route::get('/home','HomeController@index');

Auth::routes();

Route::post('/ocr','Indicator\ImageController@OCR');

Route::any('/logout','Auth\LoginController@logout');


    Route::group(['prefix'=>'indicator'],function(){
    Route::post('upload','Indicator\ImageController@upload');
    Route::get('upload','Indicator\ImageController@showUploadForm');
    Route::get('important/{IndicatorName}','Indicator\IndicatorController@important');
    Route::get('unimportant/{IndicatorName}','Indicator\IndicatorController@unimportant');
    Route::get('changeData/{ImageId}','Indicator\ImageController@changeImageDate');
    Route::get('record/{UserId}','Indicator\ImageController@record');
    Route::post('saveData','Indicator\ImageController@saveImageDate');
    Route::get('one','Indicator\IndicatorController@showOne');
    Route::get('show/user/{UserId}','Indicator\IndicatorController@showIndicatorByUserId');
    Route::get('show/{IndicatorName}','Indicator\IndicatorController@showIndicatorByName');
});

Route::group(['prefix'=>'family'],function(){
    Route::post('createFamily','Family\FamilyController@createFamily');
    Route::get('apply/{familyName}','Family\FamilyController@apply');
    Route::get('add','Family\FamilyController@add');
    Route::get('accept/{UserId}','Family\FamilyController@accept');
    Route::get('info/{FamilyId}','Family\FamilyController@showMembers');
    Route::get('showApply','Family\FamilyController@showApply');
    Route::get('dealWith','Family\FamilyController@dealsWith');
    Route::get('newMember','Family\FamilyController@showNewMembers');
    Route::post('invite','Family\FamilyController@invite');
    Route::get('del/{UserId}','Family\FamilyController@del');
    Route::get('quit','Family\FamilyController@quit');
    Route::get('test','Family\FamilyController@test');
});

Route::group(['prefix'=>'user'],function(){
    Route::get('info','User\UserController@info');
    Route::get('change','User\UserController@change');
    Route::post('update','User\UserController@update');
    Route::post('upload','User\UserController@upload');

});