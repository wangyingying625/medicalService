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
Route::get('/record', function () {
    return view('record');
});
Route::get('/pictures', function () {
    return view('pictures');
});
Route::get('/family', function () {
    return view('family');
});
Route::get('/geRen', function () {
    return view('geRen');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'=>'indicator'],function(){
    Route::get('upload','Indicator\IndicatorController@showUpload');
});