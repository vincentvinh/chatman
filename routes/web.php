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
Route::get('/message', 'MessageController@index');
Route::post('/message', 'MessageController@store');
Route::get('/messageShow', 'MessageController@show')->name('show');
//Groupe
Route::get('/group', 'GroupController@index');
Route::post('/group', 'GroupController@store');
