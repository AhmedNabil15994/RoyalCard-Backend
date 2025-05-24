<?php

Route::group(['prefix' => 'login'], function () {

    // if (env('LOGIN')):

    // Show Login Form
    Route::get('/', 'LoginController@showLogin')
        ->name('dashboard.login')
        ->middleware('guest');

    // Submit Login
    Route::post('/', 'LoginController@postLogin')->name('dashboard.login.post');

    // endif;
});


Route::group(['prefix' => 'logout','middleware' => 'dashboard.auth'], function () {

    // Logout
    Route::any('/', 'LoginController@logout')
    ->name('dashboard.logout');
});

Route::group(['prefix' => 'verify-otp','middleware' => 'dashboard.auth'], function () {

    // Logout
    Route::get('/', 'LoginController@verify')
        ->name('dashboard.auth.verify');

    Route::post('/', 'LoginController@postVerify')
        ->name('dashboard.auth.post_verify');
});
