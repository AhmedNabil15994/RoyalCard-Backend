<?php
use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group( function () {

    Route::get('reports/customers-sales'	,'ReportController@customers')
        ->name('reports.customers');

    Route::get('reports/customers-datatable'	,'ReportController@customers_datatable')
        ->name('reports.customers_datatable');

    Route::get('reports/products-sales'	,'ReportController@products')
        ->name('reports.products');

    Route::get('reports/products-datatable'	,'ReportController@products_datatable')
        ->name('reports.products_datatable');

    Route::get('reports/payments-sales'	,'ReportController@payments')
        ->name('reports.payments');

    Route::get('reports/payments-datatable'	,'ReportController@payments_datatable')
        ->name('reports.payments_datatable');

});
