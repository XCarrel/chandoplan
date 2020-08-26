<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/allSchedules', 'HomeController@allSchedules')->name('allSchedules');
Route::resource('activity','ActivityController')->register();
Route::post('activity/{activity}/subscribe', 'ActivityController@subscribe')->name('activity.subscribe');
Route::post('activity/{activity}/unsubscribe', 'ActivityController@unsubscribe')->name('activity.unsubscribe');

