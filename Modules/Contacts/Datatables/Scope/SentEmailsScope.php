<?php

namespace Modules\Contacts\Datatables\Scope;

use Modules\Contacts\Entities\Contact;
use Modules\Platform\Core\Helper\CompanySettings;
use Modules\Platform\Core\Interfaces\CrudRelatedScope;
use Modules\SentEmails\Entities\EmailContext;
use Yajra\DataTables\Contracts\DataTableScope;

/**
 * Class SentEmailsScope
 * @package Modules\Contacts\Datatables\Scope
 */
class SentEmailsScope implements DataTableScope, CrudRelatedScope
{
    private $relation;

    private $whereCondition;

    private $whereType;

    private $entityId;

    public function relation($relation, $whereCondition = null, $whereType = null , $entityId = null)
    {
        $this->relation = $relation;
        $this->whereCondition = $whereCondition;
        $this->whereType = $whereType;
        $this->entityId = $entityId;
    }

    public function apply($query)
    {

        $context = CompanySettings::getContext();

        $emailIds = EmailContext::where('entity_id',$this->entityId)
            ->where('company_id',$context->get('company_id'))
            ->where('entity_type',Contact::class)->pluck('email_id');

        $query->whereIn('emails.id',$emailIds);

    }
}
