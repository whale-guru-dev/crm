<?php

namespace Modules\Tickets\Http\Controllers\Settings;

use Modules\Platform\Core\Http\Forms\NameIconDictionaryForm;
use Modules\Tickets\Datatables\Settings\TicketPriorityDatatable;
use Modules\Tickets\Entities\TicketPriority;
use Modules\Platform\Core\Http\Controllers\ModuleCrudController;
use Modules\Platform\Core\Http\Forms\NameDictionaryForm;
use Modules\Platform\Core\Http\Requests\NameDictionaryRequest;

class PriorityController extends ModuleCrudController
{
    protected $datatable = TicketPriorityDatatable::class;
    protected $formClass = NameIconDictionaryForm::class;
    protected $storeRequest = NameDictionaryRequest::class;
    protected $updateRequest = NameDictionaryRequest::class;
    protected $entityClass = TicketPriority::class;

    protected $disableWidgets = true;

    protected $moduleDictionary = true;


    protected $moduleName = 'tickets';

    protected $settingsBackRoute = 'tickets.tickets.index';

    protected $permissions = [
        'browse' => 'tickets.settings',
        'create' => 'tickets.settings',
        'update' => 'tickets.settings',
        'destroy' => 'tickets.settings'
    ];

    protected $showFields = [
        'details' => [
            'name' => ['type' => 'text', 'col-class' => 'col-lg-12'],
            'icon' => ['type' => 'text', 'col-class' => 'col-lg-12'],
            'color' => ['type' => 'text', 'col-class' => 'col-lg-12'],
        ]
    ];

    protected $languageFile = 'tickets::tickets.priority';

    protected $routes = [
        'index' => 'tickets.priority.index',
        'create' => 'tickets.priority.create',
        'show' => 'tickets.priority.show',
        'edit' => 'tickets.priority.edit',
        'store' => 'tickets.priority.store',
        'destroy' => 'tickets.priority.destroy',
        'update' => 'tickets.priority.update'
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
