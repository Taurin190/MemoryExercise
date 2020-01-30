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

Route::get('/exercise', 'ExerciseController@index')->name('exercise');

Route::get('/list', 'ExerciseController@list')->name('exercise');

Route::get('/create', 'ExerciseController@form')->name('form');

Route::post('/create', 'ExerciseController@create')->name('create');

Route::get('/setting', 'HomeController@index')->name('setting');
