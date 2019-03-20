<?php

namespace Modules\ServiceContracts\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class ServiceContractsDatabaseSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {

        $dictValues = [
            ['name' => 'Low', 'company_id' => $companyId],
            ['name' => 'Normal', 'company_id' => $companyId],
            ['name' => 'High', 'company_id' => $companyId],
            ['name' => 'Urgent', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('service_contracts_dict_priority', $dictValues);

        $dictValues = [
            ['name' => 'Undefined', 'company_id' => $companyId],
            ['name' => 'In planning', 'company_id' => $companyId],
            ['name' => 'On hold', 'company_id' => $companyId],
            ['name' => 'Open', 'company_id' => $companyId],
            ['name' => 'In progress', 'company_id' => $companyId],
            ['name' => 'Wait for response', 'company_id' => $companyId],
            ['name' => 'Closed', 'company_id' => $companyId],
            ['name' => 'Archived', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('service_contracts_dict_status', $dictValues);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('service_contracts_dict_priority')->truncate();
        DB::table('service_contracts_dict_status')->truncate();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());
    }
}
