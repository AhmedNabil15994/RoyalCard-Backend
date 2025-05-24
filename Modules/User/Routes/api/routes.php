<?php


Route::group(['prefix' => '/auth', 'middleware' => 'auth:sanctum'], function () {

    Route::get('profile', 'UserController@profile')->name('api.auth.profile');
    Route::post('profile', 'UserController@updateProfile')->name('api.auth.update.profile');
    Route::post('change-password', 'UserController@changePassword')->name('api.auth.change.password');
    Route::post('deleteUser', 'UserController@deleteUser')->name('api.auth.deleteUser');
});

Route::group(['prefix' => '/auth/wallets'], function () {

    Route::post('chargeWallet', 'UserWalletController@chargeWallet')->name('api.wallets.chargeWallet')->middleware('auth:sanctum');
    Route::get('success-upayment', 'UserWalletController@successUpayment')->name('api.wallets.success.upayment');
    Route::get('failed-upayment', 'UserWalletController@failedUpayment')->name('api.wallets.failed.upayment');

    Route::get('success-moyasar', 'UserWalletController@successMoyasar')->name('api.wallets.success.moyasar');
    Route::get('failed-moyasar', 'UserWalletController@failedMoyasar')->name('api.wallets.failed.moyasar');

    Route::get('success-knet', 'UserWalletController@successKnet')->name('api.wallets.success.knet');
    Route::any('failed-knet', 'UserWalletController@failedKnet')->name('api.wallets.failed.knet');

    Route::get('success-myfatoorah', 'UserWalletController@successMyfatoorah')->name('api.wallets.success.myfatoorah');
    Route::any('failed-myfatoorah', 'UserWalletController@failedMyfatoorah')->name('api.wallets.failed.myfatoorah');

});


Route::group(['prefix' => '/auth/favourites', 'middleware' => 'auth:sanctum'], function () {

    Route::get('/', 'UserFavouritesController@list')->name('api.favourites.list');
    Route::post('toggleFavorite', 'UserFavouritesController@toggleFav')->name('api.favourites.toggleFav');
});

Route::group(['prefix' => '/auth/ratings', 'middleware' => 'auth:sanctum'], function () {

    Route::get('/', 'UserRatingsController@list')->name('api.ratings.list');
    Route::post('/', 'UserRatingsController@rate')->name('api.ratings.rate');
});
