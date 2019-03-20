<?php

namespace Modules\Contacts\Http\Controllers\Tabs;

use Modules\ContactEmails\Entities\ContactEmail;
use Modules\Contacts\Datatables\Scope\SentEmailsScope;
use Modules\Contacts\Datatables\Tabs\ContactEmailDatatable;
use Modules\Contacts\Datatables\Tabs\ContactSentEmailsDatatable;
use Modules\Contacts\Entities\Contact;
use Modules\Platform\Core\Datatable\Scope\BasicRelationScope;
use Modules\Platform\Core\Http\Controllers\ModuleCrudRelationController;
use Modules\SentEmails\LaravelDatabaseEmails\Email;


/**
 * Class ContactCallsController
 * @package Modules\Contacts\Http\Controllers\Tabs
 */
class ContactSentEmailsController extends ModuleCrudRelationController
{
    protected $datatable = ContactSentEmailsDatatable::class;

    protected $ownerModel = Contact::class;

    protected $relationModel = Email::class;

    protected $ownerModuleName = 'contacts';

    protected $relatedModuleName = 'sentemails';

    protected $scopeLinked = SentEmailsScope::class; // Create Custom Relation Scope

    protected $modelRelationName = 'contactEmails';

    protected $relationType = self::RT_ONE_TO_MANY;

    protected $belongsToName = 'contact';



}
