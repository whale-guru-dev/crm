<?php

namespace Modules\Testimonials\Http\Controllers;

use Modules\Platform\Core\Http\Controllers\ModuleCrudController;

use Modules\Testimonials\Datatables\TestimonialsDatatable;
use Modules\Testimonials\Entities\Testimonial;
use Modules\Testimonials\Http\Forms\TestimonialsForm;
use Modules\Testimonials\Http\Requests\TestimonialsRequest;

class TestimonialsController extends ModuleCrudController
{

    protected $datatable = TestimonialsDatatable::class;
    protected $formClass = TestimonialsForm::class;
    protected $storeRequest = TestimonialsRequest::class;
    protected $updateRequest = TestimonialsRequest::class;
    protected $entityClass = Testimonial::class;

    protected $moduleName = 'testimonials';

    protected $permissions = [
        'browse' => 'testimonials.browse',
        'create' => 'testimonials.create',
        'update' => 'testimonials.update',
        'destroy' => 'testimonials.destroy'
    ];

    protected $moduleSettingsLinks = [


    ];

    protected $settingsPermission = 'testimonials.settings';

    protected $showFields = [

        'information' => [

            'product_id' => [
                'type' => 'manyToOne',
                'relation' => 'product',
                'column' => 'name',
                'dont_translate' => true,
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],

            'contact_id' => [
                'type' => 'manyToOne',
                'relation' => 'contact',
                'column' => 'full_name',
                'dont_translate' => true,
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],

        ],

        'comment' => [

            'comment' => [
                'type' => 'wyswig',
                'col-class' => 'col-lg-12 col-md-12 col-sm-12'
            ],

        ],

    ];

    protected $languageFile = 'testimonials::testimonials';

    protected $routes = [
        'index' => 'testimonials.testimonials.index',
        'create' => 'testimonials.testimonials.create',
        'show' => 'testimonials.testimonials.show',
        'edit' => 'testimonials.testimonials.edit',
        'store' => 'testimonials.testimonials.store',
        'destroy' => 'testimonials.testimonials.destroy',
        'update' => 'testimonials.testimonials.update'
    ];

    public function __construct()
    {
        parent::__construct();

    }

}
