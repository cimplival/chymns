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

Route::get('/', 'Core\SongsController@index');

Route::post('/', 'Core\SongsController@search');

Route::get('/song/{id}', 'Core\SongsController@show');
