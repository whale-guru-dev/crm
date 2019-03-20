<?php

namespace Modules\Accounts\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class AccountsDatabaseSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {

        Model::unguard();

        $accounts_dict_industry = [
            ['name' => 'Communications', 'company_id' => $companyId],
            ['name' => 'Technology', 'company_id' => $companyId],
            ['name' => 'Government/Military', 'company_id' => $companyId],
            ['name' => 'Manufacturing', 'company_id' => $companyId],
            ['name' => 'Financial Service', 'company_id' => $companyId],
            ['name' => 'IT Service', 'company_id' => $companyId],
            ['name' => 'Education', 'company_id' => $companyId],
            ['name' => 'Pharma', 'company_id' => $companyId],
            ['name' => 'Real Estate', 'company_id' => $companyId],
            ['name' => 'Consulting', 'company_id' => $companyId],
            ['name' => 'Health Care', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('accounts_dict_industry', $accounts_dict_industry);

        $accounts_dict_rating = [
            ['name' => 'Acquired', 'company_id' => $companyId],
            ['name' => 'Active', 'company_id' => $companyId],
            ['name' => 'Market failed', 'company_id' => $companyId],
            ['name' => 'Project cancelled', 'company_id' => $companyId],
            ['name' => 'Shut down', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('accounts_dict_rating', $accounts_dict_rating);

        $accounts_dict_type = [
            ['name' => 'Vendor', 'company_id' => $companyId],
            ['name' => 'Customer', 'company_id' => $companyId],
            ['name' => 'Investor', 'company_id' => $companyId],
            ['name' => 'Partner', 'company_id' => $companyId],
            ['name' => 'Press', 'company_id' => $companyId],
            ['name' => 'Prospect', 'company_id' => $companyId],
            ['name' => 'Reseller', 'company_id' => $companyId],
            ['name' => 'Distributor', 'company_id' => $companyId],
            ['name' => 'Supplier', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('accounts_dict_type', $accounts_dict_type);

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('accounts_dict_industry')->truncate();
        DB::table('accounts_dict_rating')->truncate();
        DB::table('accounts_dict_type')->truncate();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());


    }
}
