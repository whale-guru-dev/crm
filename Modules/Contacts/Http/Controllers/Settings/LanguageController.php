<?php

namespace Modules\Contacts\Http\Controllers\Settings;

use Modules\Contacts\Datatables\Settings\ContactSourceDatatable;
use Modules\Contacts\Datatables\Settings\CustomerLanguageDatatable;
use Modules\Contacts\Entities\ContactSource;
use Modules\Contacts\Entities\CustomerLanguage;
use Modules\Contacts\Http\Forms\LanguageForm;
use Modules\Platform\Core\Http\Controllers\ModuleCrudController;
use Modules\Platform\Core\Http\Forms\NameDictionaryForm;
use Modules\Platform\Core\Http\Forms\NameIconDictionaryForm;
use Modules\Platform\Core\Http\Requests\NameDictionaryRequest;

class LanguageController extends ModuleCrudController
{
    protected $datatable = CustomerLanguageDatatable::class;
    protected $formClass = LanguageForm::class;
    protected $storeRequest = NameDictionaryRequest::class;
    protected $updateRequest = NameDictionaryRequest::class;
    protected $entityClass = CustomerLanguage::class;

    protected $disableWidgets = true;

    protected $moduleDictionary = true;


    protected $moduleName = 'contacts';

    protected $permissions = [
        'browse' => 'contacts.settings',
        'create' => 'contacts.settings',
        'update' => 'contacts.settings',
        'destroy' => 'contacts.settings'
    ];

    protected $settingsBackRoute = 'contacts.contacts.index';

    protected $showFields = [
        'details' => [
            'name' => ['type' => 'text', 'col-class' => 'col-lg-12'],
            'code' => ['type' => 'text', 'col-class' => 'col-lg-12'],
        ]
    ];

    protected $languageFile = 'contacts::contacts.language';

    protected $routes = [
        'index' => 'contacts.language.index',
        'create' => 'contacts.language.create',
        'show' => 'contacts.language.show',
        'edit' => 'contacts.language.edit',
        'store' => 'contacts.language.store',
        'destroy' => 'contacts.language.destroy',
        'update' => 'contacts.language.update'
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
