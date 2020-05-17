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

Route::get('/exercise', 'ExerciseController@index')->name('exercise.index');

Route::get('/exercise/list', 'ExerciseController@list')->name('exercise.list');

Route::get('/exercise/create', 'ExerciseController@form')->name('exercise.form');

Route::post('/exercise/confirm', 'ExerciseController@confirm')->name('exercise.confirm');

Route::get('/setting', 'HomeController@index')->name('setting');

Route::get('/workbook/list', 'WorkbookController@list')->name('workbook.list');

Route::get('/workbook/{uuid}', 'WorkbookController@detail')->name('workbook.detail');

Route::post('/workbook/{uuid}/complete', 'WorkbookController@complete')->name('workbook.complete');
