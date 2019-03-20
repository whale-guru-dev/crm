<?php

namespace Modules\Vendors\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class VendorsDatabaseSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {

        $dictValues = [
            ['name' => 'Outside services professional fees', 'company_id' => $companyId],
            ['name' => 'Advertising marketing promotion', 'company_id' => $companyId],
            ['name' => 'Rent and occupancy related', 'company_id' => $companyId],
            ['name' => 'Supplies', 'company_id' => $companyId],
            ['name' => 'Taxes and licenses', 'company_id' => $companyId],
            ['name' => 'Employee fringe benefits', 'company_id' => $companyId],
            ['name' => 'Utilities', 'company_id' => $companyId],
            ['name' => 'Travel and entertainment', 'company_id' => $companyId],
            ['name' => 'Insurance', 'company_id' => $companyId],
            ['name' => 'Security', 'company_id' => $companyId],
            ['name' => 'Auto', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('vendors_dict_category', $dictValues);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('vendors_dict_category')->truncate();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());
    }
}
