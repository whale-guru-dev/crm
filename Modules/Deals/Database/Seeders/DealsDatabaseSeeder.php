<?php

namespace Modules\Deals\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class DealsDatabaseSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {
        $deals_dict_business_type = [
            ['name' => 'Existing business', 'company_id' => $companyId],
            ['name' => 'New business', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('deals_dict_business_type', $deals_dict_business_type);

        $deals_dict_stage = [
            ['name' => 'Qualification', 'company_id' => $companyId],
            ['name' => 'Needs analysis', 'company_id' => $companyId],
            ['name' => 'Value proposition', 'company_id' => $companyId],
            ['name' => 'Identify decision makers', 'company_id' => $companyId],
            ['name' => 'Proposal price quote', 'company_id' => $companyId],
            ['name' => 'Negotiation review', 'company_id' => $companyId],
            ['name' => 'Closed won', 'company_id' => $companyId],
            ['name' => 'Closed lost', 'company_id' => $companyId],
            ['name' => 'Closed lost to competition', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('deals_dict_stage', $deals_dict_stage);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('deals_dict_business_type')->truncate();
        DB::table('deals_dict_stage')->truncate();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());

    }
}
