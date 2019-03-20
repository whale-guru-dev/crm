<?php

/**
 * More information about rate limit
 * https://github.com/GrahamCampbell/Laravel-Throttle
 */
Route::group(['middleware' => ['web','json.request','GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:50,30'], 'prefix' => 'api/webform', 'namespace' => 'Modules\Api\Http\Controllers'], function () {

    Route::group(['prefix' => 'contacts'], function (){
        Route::post('create','Webform\ContactsWebformController@store');
    });

    Route::group(['prefix' => 'leads'], function (){
        Route::post('create','Webform\LeadsWebformController@store');
    });

});


Route::group(['middleware' => 'web', 'prefix' => 'api', 'namespace' => 'Modules\Api\Http\Controllers'], function () {

    Route::any('login', 'ApiAuthController@login');

    Route::group(['prefix' => 'saas'], function (){


        Route::post('/save-or-update-user','Saas\SaasApiController@saveOrUpdateUser');

        Route::post('/delete-user','Saas\SaasApiController@deleteUser');

        Route::post('/validate','Saas\SaasApiController@validateAccount');

        Route::post('/register','Saas\SaasApiController@registerCompany');

        Route::post('/deactivate-account','Saas\SaasApiController@deactivateAccount');

        Route::post('/resume-account','Saas\SaasApiController@resumeAccount');

        Route::post('/update-plan','Saas\SaasApiController@updatePlan');

    });

    Route::group(['prefix' => 'leads'], function (){
        Route::get('/','LeadsApiController@index');
        Route::get('get/{id}','LeadsApiController@get');
        Route::post('create','LeadsApiController@store');
        Route::post('update/{id}','LeadsApiController@update');
        Route::delete('delete/{id}','LeadsApiController@destroy');
    });

    Route::group(['prefix' => 'contacts'], function (){
        Route::get('/','ContactsApiController@index');
        Route::get('get/{id}','ContactsApiController@get');
        Route::post('create','ContactsApiController@store');
        Route::post('update/{id}','ContactsApiController@update');
        Route::delete('delete/{id}','ContactsApiController@destroy');
    });

    Route::group(['prefix' => 'tickets'], function (){
        Route::get('/','TicketsApiController@index');
        Route::get('get/{id}','TicketsApiController@get');
        Route::post('create','TicketsApiController@store');
        Route::post('update/{id}','TicketsApiController@update');
        Route::delete('delete/{id}','TicketsApiController@destroy');
    });

});
