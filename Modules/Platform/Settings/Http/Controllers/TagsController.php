<?php

namespace Modules\Platform\Settings\Http\Controllers;

use Modules\Platform\Core\Http\Controllers\ModuleCrudController;
use Modules\Platform\Settings\Datatables\TagsDatatable;
use Modules\Platform\Settings\Entities\BapTags;
use Modules\Platform\Settings\Http\Forms\TagForm;
use Modules\Platform\Settings\Http\Requests\TagsSettingsRequest;
use Modules\Platform\Settings\Repositories\TagsRepository;
use Spatie\Tags\Tag;

/**
 * Class TagsController
 * @package Modules\Platform\Settings\Http\Controllers
 */
class TagsController extends ModuleCrudController
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

    protected $entityClass = BapTags::class;

    protected $datatable = TagsDatatable::class;

    protected $formClass = TagForm::class;

    protected $storeRequest = TagsSettingsRequest::class;

    protected $updateRequest = TagsSettingsRequest::class;

    protected $repository = TagsRepository::class;

    protected $showFields = [
        'details' => [
            'name' => ['type' => 'text', 'col-class' => 'col-lg-12 col-md-3 col-sm-6'],
        ]
    ];

    protected $languageFile = 'settings::tags';


    protected $routes = [
        'index' => 'settings.tags.index',
        'create' => 'settings.tags.create',
        'show' => 'settings.tags.show',
        'edit' => 'settings.tags.edit',
        'store' => 'settings.tags.store',
        'destroy' => 'settings.tags.destroy',
        'update' => 'settings.tags.update'
    ];
}
