<?php

namespace Modules\SentEmails\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Modules\Platform\Account\Service\UserMailService;
use Modules\Platform\Core\Http\Controllers\ModuleCrudController;
use Modules\SentEmails\Datatables\SentEmailDatatable;
use Modules\SentEmails\Http\Forms\SentEmailForm;
use Modules\SentEmails\Http\Requests\SentEmailsRequest;
use Modules\SentEmails\LaravelDatabaseEmails\Email;
use Modules\SentEmails\Service\SendEmailService;


class SentEmailsController extends ModuleCrudController
{

    protected $datatable = SentEmailDatatable::class;

    protected $formClass = SentEmailForm::class;

    protected $storeRequest = SentEmailsRequest::class;

    protected $updateRequest = SentEmailsRequest::class;

    protected $entityClass = Email::class;

    protected $moduleName = 'sentemails';

    protected $permissions = [
        'browse' => 'sentemails.browse',
        'create' => 'sentemails.create',
        'update' => 'sentemails.update',
        'destroy' => 'sentemails.destroy'
    ];


    protected $moduleSettingsLinks = [


    ];

    protected $settingsPermission = 'sentemails.settings';

    protected $showFields = [

        'information' => [

            'recipient' => [
                'type' => 'text',
                'col-class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12'
            ],
            'cc' => [
                'type' => 'text',
                'col-class' => 'col-lg-6 col-md-6 col-sm-12 col-xs-12'
            ],
            'bcc' => [
                'type' => 'text',
                'col-class' => 'col-lg-6 col-md-6 col-sm-12 col-xs-12'
            ],
            'subject' => [
                'type' => 'text',
                'col-class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12'
            ],
            'body' => [
                'type' => 'text',
                'col-class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12'
            ],
        ],


    ];

    protected $languageFile = 'sentemails::sentemails';

    protected $routes = [
        'index' => 'sentemails.sentemails.index',
        'create' => 'sentemails.sentemails.create',
        'show' => 'sentemails.sentemails.show',
        'edit' => 'sentemails.sentemails.edit',
        'store' => 'sentemails.sentemails.store',
        'destroy' => 'sentemails.sentemails.destroy',
        'update' => 'sentemails.sentemails.update'
    ];

    private $userMailService;

    private $sendEmailService;

    public function __construct(UserMailService $mailService, SendEmailService $sendEmailService)
    {
        parent::__construct();
        $this->userMailService = $mailService;
        $this->sendEmailService = $sendEmailService;

    }



    public function store()
    {

        $request = \App::make($this->storeRequest ?? Request::class);

        $mode = $request->get('entityCreateMode', self::FORM_MODE_FULL);

        if ($this->demoMode) {
            if (config('bap.demo')) {

                return response()->json([
                    'type' => 'error',
                    'message' => trans('core::core.you_cant_do_that_its_demo'),
                    'action' => 'refresh_datatable'
                ]);
            }
        }

        if ($this->permissions['create'] != '' && !\Auth::user()->hasPermissionTo($this->permissions['create'])) {
            return response()->json([
                'type' => 'error',
                'message' => trans('core::core.entity.you_dont_have_access'),
                'action' => 'show_message'
            ]);
        }

        try {
            $this->sendEmailService->storeAndSendEmail($request->all());

            return response()->json([
                'type' => 'success',
                'message' => trans('core::core.entity.created'),
                'action' => 'refresh_datatable'
            ]);
        }catch (\Exception $exception){

            dd($exception);

            return response()->json([
                'type' => 'error',
                'message' => trans('core::core.error_please_check_application_log'). $exception,
                'action' => 'refresh_datatable'
            ]);

        }

    }

    public function emailTags(Request $request)
    {

        $service = App::make(SendEmailService::class);

        return response()->json(
            $service->getEmailTags()
        );

    }

    /**
     * @param $request
     * @param $entity
     */
    public function afterStore($request, &$entity)
    {

    }

    /**
     * @param $request
     * @param $entity
     */
    public function afterUpdate($request, &$entity)
    {

    }

    /**
     * Setup Create Form Data
     */
    public function setupCreateFormData()
    {
        $mailSettings = $this->userMailService->getSettings();

        $params = request()->all();

        $entityClass = $params['relatedEntity'];

        $entityClass = str_replace('&quot;', '', $entityClass);
        $entityClass = str_replace('"', '', $entityClass);

        $entity = app($entityClass)->find($params['relatedEntityId']);

        if (!empty($entity)) {
            $this->createFormData = [
                'body' => $mailSettings->mail_signature,
                'recipient' => $entity->email
            ];
        }

    }


}
