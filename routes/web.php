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

//Auth::routes();
Route::namespace ('Auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login')->uses('LoginController@showLoginForm')->name('login');
        Route::post('login')->uses('LoginController@login')->name('login.attempt');
        Route::get('password/reset')->uses('ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email')->uses('ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}')->uses('ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset')->uses('ResetPasswordController@reset')->name('password.update');
    });

    Route::post('logout')->name('logout')->uses('LoginController@logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/downloads/{date?}')->uses('DownloadController@index')->name('downloads.show');

    Route::get('/')->uses('DashboardController@index')->name('home');

});

//Route::get('/home', 'HomeController@index')->name('home');

// $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// $this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');