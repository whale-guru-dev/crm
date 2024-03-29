<?php

namespace Modules\Documents\Entities;

use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Platform\Core\Entities\CachableModel;

/**
 * Modules\Documents\Entities\DocumentStatus
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Core\Entities\CachableModel disableCache()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Documents\Entities\DocumentStatus onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Documents\Entities\DocumentStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Documents\Entities\DocumentStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Documents\Entities\DocumentStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Documents\Entities\DocumentStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Documents\Entities\DocumentStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Core\Entities\CachableModel withCacheCooldownSeconds($seconds)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Documents\Entities\DocumentStatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Documents\Entities\DocumentStatus withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Documents\Entities\DocumentStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Documents\Entities\DocumentStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Documents\Entities\DocumentStatus query()
 */
class DocumentStatus extends CachableModel
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
    public $table = 'documents_dict_status';

    public $fillable = [
        'name',
        'company_id'
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
    ];
}
