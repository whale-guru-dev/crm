<?php

namespace Modules\Platform\Companies\Entities;


use Illuminate\Database\Eloquent\Model;
use Modules\Platform\Companies\Service\CompanyService;


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
class Company extends Model
{

    public $table = 'bap_companies';

    protected $fillable = [
        'name',
        'description',
        'is_enabled',
        'user_limit',
        'storage_limit',
        'plan_id'
    ];

    public function plan()
    {
        return $this->belongsTo(CompanyPlan::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function (Company $company) {

            $companyService = \App::make(CompanyService::class);

            $companyService->seedCompany($company);

        });

    }

}
