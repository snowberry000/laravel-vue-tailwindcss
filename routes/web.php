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

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Index', [
        'data' => 'fuck',
    ]);
});

//Auth::routes();
Route::namespace ('Auth', function () {
    Route::get('login')->name('login')->uses('LoginController@showLoginForm')->middleware('guest');
    Route::post('login')->name('login.attempt')->uses('LoginController@login')->middleware('guest');
    Route::post('logout')->name('logout')->uses('LoginController@logout');
});

Route::get('/home', 'HomeController@index')->name('home');