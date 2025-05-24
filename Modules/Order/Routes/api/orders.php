<?php

use Illuminate\Support\Facades\Route;
//
Route::group(['middleware' => [ 'auth:sanctum' ]], function () {
    Route::post('/checkout', 'OrderController@create')->name('api.order.create');
    Route::get('/orders', 'OrderController@index')->name('api.orders.index');
    Route::get('/orders/{id}', 'OrderController@show')->name('api.orders.show');
    Route::post('/orders/{id}/cancel', 'OrderController@cancel')->name('api.orders.cancel');
});

Route::get('success-upayment', 'OrderController@successUpayment')->name('api.orders.success.upayment');
Route::get('failed-upayment', 'OrderController@failedUpayment')->name('api.orders.failed.upayment');

Route::get('success-moyasar', 'OrderController@successMoyasar')->name('api.orders.success.moyasar');
Route::get('failed-moyasar', 'OrderController@failedMoyasar')->name('api.orders.failed.moyasar');

Route::get('success-myfatoorah', 'OrderController@successMyfatoorah')->name('api.orders.success.myfatoorah');
Route::get('failed-myfatoorah', 'OrderController@failedMyfatoorah')->name('api.orders.failed.myfatoorah');

Route::get('success-knet', 'OrderController@successKnet')->name('api.orders.success.knet');
Route::any('failed-knet', 'OrderController@failedKnet')->name('api.orders.failed.knet');

Route::group(['middleware' => [ 'auth:sanctum' ]], function () {
    Route::get('/invoices', 'OrderController@invoices')->name('api.invoices.index');
    Route::get('/invoices/{id}', 'OrderController@showInvoice')->name('api.invoices.show');
});
