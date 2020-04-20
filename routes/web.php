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
    Route::post('/videos/request')->uses('VideoController@submitrequest')->name('video.submitrequest');
    Route::get('/release/{id}')->uses('ReleaseController@download')->name('release.download');

});

Route::group(['namespace' => 'Admin', 'middleware' => ['role:Admin']], function () {
    Route::get('kyc/{user}/confirm')->uses('KycController@confirm')->name('kyc.confirm');
    Route::post('kyc/{user}/confirm')->uses('KycController@approve')->name('kyc.approve');
    Route::get('kyc/view/{file}')->uses('KycController@file')->name('kyc.view');

    Route::name('admin.')->prefix('admin')->group(function () {
        Route::get('payouts')->uses('PayoutController@index')->name('payouts');
        Route::post('payouts/{payout}')->uses('PayoutController@markPaid')->name('payouts.markpaid');
        Route::post('payouts/{payout}/unpaid')->uses('PayoutController@markUnpaid')->name('payouts.markunpaid');
        /**
         * Video aproval routes
         */
        Route::post('videos/approve')->uses('VideoController@approve')->name('videos.approve');
        Route::post('videos/reject')->uses('VideoController@reject')->name('videos.reject');
        Route::get('videos')->uses('VideoController@index')->name('videos');
        /**
         * Contributors routes
         */
        Route::get('contributors')->uses('ContributorController@index')->name('contributors');
        Route::get('contributors/{contributor?}')->uses('ContributorController@show')->name('contributors.show');
        Route::post('contributors/{contributor?}/video')->uses('ContributorController@enableVideo')->name('contributors.video.enable');
    });

});

if (app()->env == 'local') {
    Route::get('mail', 'testMailController@index');

}

Route::get('/documentation/videos')->uses('VideoController@docs')->name('video.docs');
Route::get('/elastic')->uses('Admin\\ElasticController@index')->name('elastic.index');
//Route::get('/home', 'HomeController@index')->name('home');

// $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// $this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');