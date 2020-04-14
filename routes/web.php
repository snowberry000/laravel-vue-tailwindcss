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

Route::group(['namespace' => 'Auth'], function () {
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
    Route::post('/payout')->uses('PayoutController@create')->name('payout.create');
    Route::get('/kyc')->uses('KycController@create')->name('kyc.create');
    Route::post('/kyc')->uses('KycController@store')->name('kyc.store');
    Route::get('/videos')->uses('VideoController@index')->name('video.show');
    Route::post('/videos')->uses('VideoController@store')->name('video.store');
    Route::get('/release/{id}')->uses('ReleaseController@download')->name('release.download');

});

Route::group(['namespace' => 'Admin', 'middleware' => ['role:Admin']], function () {
    Route::get('admin/payouts')->uses('PayoutController@index')->name('admin.payouts');
    Route::get('kyc/{user}/confirm')->uses('KycController@confirm')->name('kyc.confirm');
    Route::post('kyc/{user}/confirm')->uses('KycController@approve')->name('kyc.approve');
    Route::get('kyc/view/{file}')->uses('KycController@file')->name('kyc.view');
    /**
     * Video aproval routes
     */
    Route::post('admin/videos/approve')->uses('VideoController@approve')->name('admin.videos.approve');
    Route::post('admin/videos/reject')->uses('VideoController@reject')->name('admin.videos.reject');
    Route::get('admin/videos')->uses('VideoController@index')->name('admin.videos');

});

if (app()->env == 'local') {
    Route::get('mail', 'testMailController@index');

}

//Route::get('/home', 'HomeController@index')->name('home');

// $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// $this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');