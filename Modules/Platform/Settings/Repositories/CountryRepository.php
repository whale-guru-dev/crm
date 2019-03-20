<?php

namespace Modules\Platform\Settings\Repositories;

use Modules\Platform\Core\Repositories\PlatformRepository;
use Modules\Platform\Settings\Entities\Country;
use Modules\Platform\Settings\Entities\Language;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CountryRepository
 * @package Modules\Platform\Settings\Repositories
 */
class CountryRepository extends PlatformRepository
{
    public function model()
    {
        return Country::class;
    }
}
