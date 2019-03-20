<?php

namespace Modules\Quotes\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class QuotesDatabaseSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {

        $dictValues = [
            ['name' => 'Fedex', 'company_id' => $companyId],
            ['name' => 'UPS', 'company_id' => $companyId],
            ['name' => 'Upss', 'company_id' => $companyId],
            ['name' => 'DHL', 'company_id' => $companyId],
            ['name' => 'Bluedart', 'company_id' => $companyId],
            ['name' => 'Other', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('quotes_dict_carrier', $dictValues);


        $dictValues = [
            ['name' => 'Created', 'company_id' => $companyId],
            ['name' => 'Delivered', 'company_id' => $companyId],
            ['name' => 'Reviewed', 'company_id' => $companyId],
            ['name' => 'Accepted', 'company_id' => $companyId],
            ['name' => 'Rejected', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('quotes_dict_stage', $dictValues);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('quotes_dict_carrier')->truncate();
        DB::table('quotes_dict_stage')->truncate();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());
    }
}
