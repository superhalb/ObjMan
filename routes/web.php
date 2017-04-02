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
    return view('home');
});

Route::resource('objects','ObjectController');
Route::get('objects/search/{name}','ObjectController@search');
Route::put('objects/{from}/{to}','ObjectController@link');
Route::delete('relations/{id}','ObjectController@unlink');
