<?php

namespace Modules\Contacts\Http\Controllers\Tabs;

use Modules\Contacts\Datatables\Tabs\ContactAssetsDatatable;
use Modules\Contacts\Datatables\Tabs\ContactTestimonialsDatatable;
use Modules\Contacts\Entities\Contact;
use Modules\Platform\Core\Datatable\Scope\BasicRelationScope;
use Modules\Platform\Core\Http\Controllers\ModuleCrudRelationController;
use Modules\Testimonials\Entities\Testimonial;

/**
 * Class ContactTestimonialsController
 * @package Modules\Contacts\Http\Controllers\Tabs
 */
class ContactTestimonialsController extends ModuleCrudRelationController
{
    protected $datatable = ContactTestimonialsDatatable::class;

    protected $ownerModel = Contact::class;

    protected $relationModel = Testimonial::class;

    protected $ownerModuleName = 'contacts';

    protected $relatedModuleName = 'testimonials';

    protected $scopeLinked = BasicRelationScope::class;

    protected $modelRelationName = 'testimonials';

    protected $relationType = self::RT_ONE_TO_MANY;

    protected $belongsToName = 'contact';

    protected $whereCondition = 'testimonials.contact_id';

    protected $whereType = self::WHERE_TYPE__COLUMN;
}
