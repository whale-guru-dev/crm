<?php

namespace Modules\Platform\Core\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Modules\Platform\Companies\Service\CompanyService;

/**
 * Cachable Model
 * 
 * Class CachableModel
 *
 * @package Modules\Platform\Core\Entities
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Core\Entities\CachableModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Core\Entities\CachableModel withCacheCooldownSeconds($seconds)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Core\Entities\CachableModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Core\Entities\CachableModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Platform\Core\Entities\CachableModel query()
 */
class CachableModel extends Model
{
    use Cachable;

    public function __construct(array $attributes = [])
    {

        $companyConext = session()->get('currentCompany');

        if(!empty($companyConext)) {
              config(['laravel-model-caching.cache-prefix' => 'company_'.$companyConext->id]);
        }

        parent::__construct($attributes);
    }
}
