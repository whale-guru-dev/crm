<?php

namespace Modules\Platform\Companies\Repositories;

use Modules\Platform\Companies\Entities\Company;
use Modules\Platform\Companies\Entities\CompanyPlan;
use Modules\Platform\Core\Repositories\PlatformRepository;


/**
 * Class CompanyPlansRepository
 * @package Modules\Platform\Companies\Repositories
 */
class CompanyPlansRepository extends PlatformRepository
{
    public function model()
    {
        return CompanyPlan::class;
    }

}
