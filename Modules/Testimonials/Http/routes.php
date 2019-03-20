<?php

Route::group(['middleware' => ['web', 'permission:testimonials.browse'], 'prefix' => 'testimonials', 'as' => 'testimonials.', 'namespace' => 'Modules\Testimonials\Http\Controllers'], function () {

    Route::get('/', 'TestimonialsController@indexRedirect');

    Route::group(['middleware' => ['web', 'permission:testimonials.settings']], function () {

    });

    Route::resource('testimonials', 'TestimonialsController');
});
