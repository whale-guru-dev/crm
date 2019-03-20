<?php

namespace Modules\Platform\Companies\Entities;


use Illuminate\Database\Eloquent\Model;
use Modules\Platform\Companies\Service\CompanyService;
use Spatie\Permission\Traits\HasPermissions;


/**
 * Modules\Platform\Companies\Entities\Company
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $is_enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Companies\Entities\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Companies\Entities\Company whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Companies\Entities\Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Companies\Entities\Company whereIsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Companies\Entities\Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Companies\Entities\Company whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $user_limit
 * @property int|null $storage_limit
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Companies\Entities\Company whereUserLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Companies\Entities\Company whereStorageLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Companies\Entities\Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Companies\Entities\Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Companies\Entities\Company query()
 */
class CompanyPlan extends Model
{
    use HasPermissions;

    protected $guard_name = 'web';

    public $table = 'bap_companies_plan';

    protected $fillable = [
        'name',
        'description',
        'api_name'
    ];

    public static function boot()
    {
        parent::boot();

    }

}
