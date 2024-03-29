<?php

namespace Modules\Quotes\Entities;

use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Platform\Core\Entities\CachableModel;

/**
 * Modules\Quotes\Entities\QuoteCarrier
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Core\Entities\CachableModel disableCache()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Quotes\Entities\QuoteCarrier onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Quotes\Entities\QuoteCarrier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Quotes\Entities\QuoteCarrier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Quotes\Entities\QuoteCarrier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Quotes\Entities\QuoteCarrier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Quotes\Entities\QuoteCarrier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Core\Entities\CachableModel withCacheCooldownSeconds($seconds)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Quotes\Entities\QuoteCarrier withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Quotes\Entities\QuoteCarrier withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Quotes\Entities\QuoteCarrier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Quotes\Entities\QuoteCarrier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Quotes\Entities\QuoteCarrier query()
 */
class QuoteCarrier extends CachableModel
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

    ];
    public $table = 'quotes_dict_carrier';

    public $fillable = [
        'name',
        'company_id'
    ];


    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
}
