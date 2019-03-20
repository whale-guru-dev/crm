<?php

Route::group(['middleware' => ['web','permission:settings.access'], 'prefix' => 'settings','as'=>'settings.', 'namespace' => 'Modules\Platform\Companies\Http\Controllers'], function () {

    Route::resource('companies', 'CompanyController', []);

    Route::resource('company-plans', 'CompanyPlansController', []);


    Route::get('/company-plans/permissions/{id}', ['as' => 'company-plans.permissions', 'uses' => 'CompanyPlansPermissionsController@setup']);
    Route::post('/company-plans/permissions/{id}', ['as' => 'company-plans.permissions-save', 'uses' => 'CompanyPlansPermissionsController@save']);

    Route::get('switch-context/{id}','CompanyContextController@switchCompany')->name('companies.switch-context');

    Route::get('drop-context', 'CompanyContextController@dropContext')->name('companies.drop-conext');

});
