<?php
use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group( function () {


    Route::get('servers/datatable'	,'ServerController@datatable')
        ->name('servers.datatable');

    Route::get('servers/{id}/copy'	,'ServerController@copy')
        ->name('servers.copy');

    Route::get('servers/deletes'	,'ServerController@deletes')
        ->name('servers.deletes');

    Route::resource('servers','ServerController')->names('servers');

});
