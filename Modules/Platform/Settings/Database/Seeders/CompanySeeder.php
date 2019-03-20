<?php

namespace Modules\Platform\Settings\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\CrudHelper;
use Modules\Platform\Core\Helper\SeederHelper;
use Modules\Platform\User\Entities\User;

/**
 * Class CompanySeeder
 * @package Modules\Platform\Settings\Database\Seeders
 */
class CompanySeeder extends SeederHelper
{

    private static $_COMPANIES = [
        [
            'id' => 1,
            'name' => 'OsCorp',
            'is_enabled' => 1,
            'description' => "Evil company that want to rule the World",
        ],
        [
            'id' => 2,
            'name' => 'Umbrella Corporation',
            'is_enabled' => 1,
            'description' => 'Our business is life itself...',
            'user_limit' => 50,
            'storage_limit' => 100
        ]
    ];

    private static $_PLANS = [
        [
            'id' => 1,
            'name' => 'Startup',
            'description' => "24 users included, 24 GB of storage, Email support, Help center access",
            'api_name' => 'startup'
        ],
        [
            'id' => 2,
            'name' => 'Standard',
            'description' => "50 users included, 100 GB of storage, Priority email support, Help center access",
            'api_name' => 'standard'
        ],
        [
            'id' => 3,
            'name' => 'Premium',
            'description' => "Unlimited users, Unlimited storage, Phone, email support, Help center access",
            'api_name' => 'premium'
        ],
        [
            'id' => 4,
            'name' => 'Trial',
            'description' => "Trial plan",
            'api_name' => 'trial'
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Model::unguard();

        DB::table('bap_companies_plan')->truncate();
        DB::table('bap_companies')->truncate();
        DB::table('tags')->truncate();

        $this->saveOrUpdate('bap_companies_plan', self::$_PLANS);

        $this->saveOrUpdate('bap_companies', self::$_COMPANIES);


    }

}
