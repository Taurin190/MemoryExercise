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

Route::get('/exercise/create', 'ExerciseController@create')->name('exercise.create');

Route::post('/exercise/confirm', 'ExerciseController@confirm')->name('exercise.confirm');

Route::post('/exercise/complete', 'ExerciseController@complete')->name('exercise.complete');

Route::get('/setting', 'HomeController@index')->name('setting');

Route::get('/workbook/list', 'WorkbookController@list')->name('workbook.list');

Route::get('/workbook/create', 'WorkbookController@create')->name('workbook.create');

Route::post('/workbook/confirm', 'WorkbookController@confirm')->name('workbook.confirm');

Route::post('/workbook/complete', 'WorkbookController@complete')->name('workbook.complete');

Route::get('/workbook/{uuid}', 'WorkbookController@detail')->name('workbook.detail');

Route::post('/workbook/{uuid}/result', 'WorkbookController@result')->name('workbook.result');
