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

Route::get('/', 'HomeController@index')->name('index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/exercise', 'ExerciseController@index')->name('exercise.index');

Route::get('/exercise/list', 'ExerciseController@list')->name('exercise.list');

Route::get('/exercise/create', 'Exercise\CreateController@create')->name('exercise.create');

Route::get('/exercise/{uuid}/edit', 'Exercise\EditController@edit')->name('exercise.edit');

Route::post('/exercise/{uuid}/edit/confirm', 'Exercise\EditController@confirm')->name('exercise.edit.confirm');

Route::post('/exercise/{uuid}/edit/complete', 'Exercise\EditController@complete')->name('exercise.edit.complete');

Route::post('/exercise/confirm', 'Exercise\CreateController@confirm')->name('exercise.confirm');

Route::post('/exercise/complete', 'Exercise\CreateController@complete')->name('exercise.complete');

Route::get('/setting', 'HomeController@index')->name('setting');

Route::get('/workbook/list', 'WorkbookController@list')->name('workbook.list');

Route::get('/workbook/create', 'Workbook\CreateController@create')->name('workbook.create');

Route::post('/workbook/confirm', 'Workbook\CreateController@confirm')->name('workbook.confirm');

Route::post('/workbook/complete', 'Workbook\CreateController@complete')->name('workbook.complete');

Route::get('/workbook/{uuid}', 'WorkbookController@detail')->name('workbook.detail');

Route::post('/workbook/{uuid}/result', 'WorkbookController@result')->name('workbook.result');

Route::get('/workbook/{uuid}/edit', 'Workbook\EditController@edit')->name('workbook.edit');

Route::post('/workbook/{uuid}/edit/confirm', 'Workbook\EditController@confirm')->name('workbook.edit.confirm');

Route::post('/workbook/{uuid}/edit/complete', 'Workbook\EditController@complete')->name('workbook.edit.complete');
