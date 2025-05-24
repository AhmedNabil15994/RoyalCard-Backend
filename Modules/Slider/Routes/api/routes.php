<?php

Route::group(['prefix' => 'sliders'], function () {
    Route::get('/', 'SliderController@index');
});
