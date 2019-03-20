<?php

Route::group(['middleware' => ['web', 'permission:sentemails.browse'], 'prefix' => 'sentemails', 'as' => 'sentemails.', 'namespace' => 'Modules\SentEmails\Http\Controllers'], function () {

    Route::get('/', 'SentEmailsController@indexRedirect');

    Route::get('/email-tags', 'SentEmailsController@emailTags');

    Route::resource('sentemails', 'SentEmailsController');
});
