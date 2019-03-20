<?php

namespace Modules\Vendors\Http\Controllers;

use Modules\Platform\Core\Http\Controllers\ModuleCrudController;
use Modules\Vendors\Datatables\VendorDatatable;
use Modules\Vendors\Entities\Vendor;
use Modules\Vendors\Http\Forms\VendorForm;
use Modules\Vendors\Http\Requests\VendorsRequest;

class VendorsController extends ModuleCrudController
{
    protected $datatable = VendorDatatable::class;
    protected $formClass = VendorForm::class;
    protected $storeRequest = VendorsRequest::class;
    protected $updateRequest = VendorsRequest::class;
    protected $entityClass = Vendor::class;

    protected $moduleName = 'vendors';


    protected $permissions = [
        'browse' => 'vendors.browse',
        'create' => 'vendors.create',
        'update' => 'vendors.update',
        'destroy' => 'vendors.destroy'
    ];

    protected $moduleSettingsLinks = [

        ['route' => 'vendors.category.index', 'label' => 'settings.category'],


    ];

    protected $settingsPermission = 'vendors.settings';

    protected $showFields = [

        'information' => [

            'name' => [
                'type' => 'text',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],
            'vendor_category_id' => [
                'type' => 'manyToOne',
                'relation' => 'vendorCategory',
                'column' => 'name',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6',
            ],

            'owned_by' => [
                'type' => 'assigned_to',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],
        ],


        'contact_data' => [

            'phone' => [
                'type' => 'text',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],


            'mobile' => [
                'type' => 'text',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],


            'email' => [
                'type' => 'text',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],


            'secondary_email' => [
                'type' => 'text',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],


            'fax' => [
                'type' => 'text',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],


            'skype_id' => [
                'type' => 'text',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],

        ],


        'address_information' => [

            'street' => [
                'type' => 'text',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],

            'city' => [
                'type' => 'text',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],

            'zip_code' => [
                'type' => 'text',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],

            'state' => [
                'type' => 'text',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],


            'country_id' => [
                'type' => 'manyToOne',
                'relation' => 'country',
                'column' => 'name',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],


        ],


        'notes' => [

            'notes' => [
                'type' => 'text',
                'col-class' => 'col-lg-12 col-md-12 col-sm-12'
            ],

        ],


    ];

    protected $languageFile = 'vendors::vendors';

    protected $routes = [
        'index' => 'vendors.vendors.index',
        'create' => 'vendors.vendors.create',
        'show' => 'vendors.vendors.show',
        'edit' => 'vendors.vendors.edit',
        'store' => 'vendors.vendors.store',
        'destroy' => 'vendors.vendors.destroy',
        'update' => 'vendors.vendors.update'
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
