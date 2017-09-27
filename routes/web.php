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
Route::get('/group', 'GroupController@index')->name('group');
Route::post('/group', 'GroupController@store');
Route::get('/group/{id}', 'GroupController@show')->name('groupMsg');
// Route::get('/grMsg/{group}', 'GroupController@storeMsg');
Route::post('/grMsg/{id}', 'GroupController@storeMsg')->name('grMsg');

Route::get('/addPers/{id}', 'GroupController@addPers');
Route::post('/addPersSub/{id}', 'GroupController@addPersSub');

Route::get('/addMe/{id}', 'GroupController@addMe')->name('addMe');

Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/accept/{id}', 'AdminController@accept')->name('accept');
Route::post('/acceptVal/{id}', 'AdminController@acceptVal');
