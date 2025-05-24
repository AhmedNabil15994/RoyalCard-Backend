<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/catalog/products' ], function () {
    Route::get('/', 'ProductController@index')->name('api.products.index');
    Route::get('/{id}', 'ProductController@show')->name('api.products.show');

});
