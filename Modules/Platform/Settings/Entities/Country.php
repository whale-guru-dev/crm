<?php

namespace Modules\Platform\Settings\Entities;

use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Platform\Core\Entities\CachableModel;

/**
 * Class Country
 * @package Modules\Platform\Settings\Entities
 */
class Country extends CachableModel
{

    use SoftDeletes, BelongsToTenants;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:255',
    ];
    public $table = 'bap_country';

    public $fillable = [
        'name',
        'alpha2',
        'alpha3',
        'is_active',
        'continent',
        'company_id'
    ];

    protected $dates = ['deleted_at', 'updated_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'alpha2' => 'string',
        'alpha3' => 'string',
        'is_active' => 'boolean'
    ];
}
