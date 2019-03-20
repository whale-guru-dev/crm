<?php

namespace Modules\Platform\Settings\Http\Controllers;

use Modules\Platform\Core\Http\Controllers\ModuleCrudController;
use Modules\Platform\Settings\Datatables\CountryDatatable;
use Modules\Platform\Settings\Datatables\LanguageDatatable;
use Modules\Platform\Settings\Entities\Country;
use Modules\Platform\Settings\Entities\Language;
use Modules\Platform\Settings\Http\Forms\CountryForm;
use Modules\Platform\Settings\Http\Forms\LanguageForm;
use Modules\Platform\Settings\Http\Requests\CountrySettingsRequest;
use Modules\Platform\Settings\Http\Requests\LanguageSettingsRequest;
use Modules\Platform\Settings\Repositories\CountryRepository;
use Modules\Platform\Settings\Repositories\LanguageRepository;

class CountryController extends ModuleCrudController
{
    public function __construct()
    {
        parent::__construct();
    }

    protected $settingsMode = true;

    protected $disableTabs = true;

    protected $moduleName = 'settings';

    protected $permissions = [
        'browse' => 'settings.access',
        'create' => 'settings.access',
        'update' => 'settings.access',
        'destroy' => 'settings.access'
    ];

    protected $entityClass = Country::class;

    protected $datatable = CountryDatatable::class;

    protected $formClass = CountryForm::class;

    protected $storeRequest = CountrySettingsRequest::class;

    protected $updateRequest = CountrySettingsRequest::class;

    protected $repository = CountryRepository::class;

    protected $showFields = [
        'details' => [
            'name' => ['type' => 'text',  'col-class'=>'col-lg-6 col-sm-6'],
            'is_active' => ['type' => 'boolean', 'col-class'=>'col-lg-6 col-sm-6'],
            'alpha2' => ['type' => 'text', 'col-class'=>'col-lg-4 col-lg-6'],
            'alpha3' => ['type' => 'text', 'col-class'=>'col-lg-4 col-lg-6'],
            'continent' => ['type' => 'text', 'col-class'=>'col-lg-4 col-lg-6'],
        ]
    ];

    protected $languageFile = 'settings::country';

    protected $routes = [
        'index' => 'settings.country.index',
        'create' => 'settings.country.create',
        'show' => 'settings.country.show',
        'edit' => 'settings.country.edit',
        'store' => 'settings.country.store',
        'destroy' => 'settings.country.destroy',
        'update' => 'settings.country.update'
    ];
}
