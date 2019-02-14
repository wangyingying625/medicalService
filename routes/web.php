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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'=>'indicator'],function(){
    Route::get('upload','Indicator\IndicatorController@showUpload');
});

Route::group(['prefix'=>'family'],function(){
    Route::get('createFamily','Family\FamilyController@createFamily');
    Route::get('add','Family\FamilyController@add');
    Route::get('del','Family\FamilyController@del');
});