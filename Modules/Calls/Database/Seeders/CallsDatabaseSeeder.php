<?php

namespace Modules\Calls\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class CallsDatabaseSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {
        $dictValues = [
            ['name' => 'Incoming', 'company_id' => $companyId],
            ['name' => 'Outgoing', 'company_id' => $companyId],
        ];

        DB::table('calls_dict_direction')->insert($dictValues);

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());
    }
}
