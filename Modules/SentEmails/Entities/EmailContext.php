<?php

namespace Modules\SentEmails\Entities;

use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailContext extends Model
{
    use SoftDeletes, BelongsToTenants;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $table = 'email_context';

    public $fillable = [
        'name',
        'email_id',
        'entity_id',
        'entity_type',
        'company_id'

    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

}
