<?php
use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group( function () {

    Route::get('products/datatable'	,'ProductController@datatable')
        ->name('products.datatable');

    Route::get('products/{id}/copy'	,'ProductController@copy')
        ->name('products.copy');

    Route::get('products/deletes'	,'ProductController@deletes')
        ->name('products.deletes');

    Route::get('products/redeem/{code}','ProductController@redeem')->name('products.redeem');
    Route::get('products/searchAjax','ProductController@searchAjax')->name('products.searchAjax');
    Route::post('products/deleteMediaFiles','ProductController@deleteMediaFiles')->name('products.deleteMediaFiles');


    Route::resource('products','ProductController')->names('products');
});
