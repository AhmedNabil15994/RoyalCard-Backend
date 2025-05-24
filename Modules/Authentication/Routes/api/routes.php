<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
    Route::post( 'send-otp', 'LoginController@sendingOtp')->name('api.auth.send.otp');
    Route::post('verified', 'LoginController@verified')->name('api.auth.password.verified');
    Route::post('login', 'LoginController@sendingOtp')->name('api.auth.login');
    Route::post('resend-code', 'LoginController@resendCode')->name('api.auth.resendCode');
    Route::post('register', 'RegisterController@register')->name('api.auth.register');
    Route::post('forget-password', 'ForgotPasswordController@forgetPassword')->name('api.auth.password.forget');

    Route::group(['prefix' => '/', 'middleware' => 'auth:sanctum'], function () {

        Route::post('logout', 'LoginController@logout')->name('api.auth.logout');
    });
});
