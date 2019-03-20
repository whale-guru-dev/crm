<?php

namespace Modules\Platform\Settings\Http\Controllers;

use Modules\Platform\Core\Http\Controllers\ModuleCrudController;
use Modules\Platform\Settings\Datatables\EmailTemplateDatatable;
use Modules\Platform\Settings\Datatables\TagsDatatable;
use Modules\Platform\Settings\Entities\EmailTemplate;
use Modules\Platform\Settings\Http\Forms\EmailTemplateForm;
use Modules\Platform\Settings\Http\Forms\TagForm;
use Modules\Platform\Settings\Http\Requests\EmailTemplatesRequest;
use Modules\Platform\Settings\Http\Requests\TagsSettingsRequest;
use Modules\Platform\Settings\Repositories\TagsRepository;
use Spatie\Tags\Tag;

/**
 * Class EmailTemplateController
 * @package Modules\Platform\Settings\Http\Controllers
 */
class EmailTemplateController extends ModuleCrudController
{
    public function __construct()
    {
        parent::__construct();
    }

    protected $settingsMode = true;

    protected $disableTabs = true;

    protected $moduleName = 'settings';

    protected $permissions = [
        'browse' => 'company.settings',
        'create' => 'company.settings',
        'update' => 'company.settings',
        'destroy' => 'company.settings'
    ];

    protected $entityClass = EmailTemplate::class;


    protected $datatable = EmailTemplateDatatable::class;

    protected $formClass = EmailTemplateForm::class;

    protected $storeRequest = EmailTemplatesRequest::class;

    protected $updateRequest = EmailTemplatesRequest::class;


    protected $showFields = [
        'details' => [
            'name' => ['type' => 'text', 'col-class' => 'col-lg-12 col-md-3 col-sm-6'],
            'subject' => ['type' => 'text', 'col-class' => 'col-lg-12 col-md-3 col-sm-6'],
            'message' => ['type' => 'wyswig', 'col-class' => 'col-lg-12 col-md-3 col-sm-6'],
        ]
    ];

    protected $languageFile = 'settings::email_templates';


    protected $routes = [
        'index' => 'settings.email_templates.index',
        'create' => 'settings.email_templates.create',
        'show' => 'settings.email_templates.show',
        'edit' => 'settings.email_templates.edit',
        'store' => 'settings.email_templates.store',
        'destroy' => 'settings.email_templates.destroy',
        'update' => 'settings.email_templates.update'
    ];
}
