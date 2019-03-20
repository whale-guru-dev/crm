<?php

namespace Modules\Leads\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class LeadsDatabaseSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {

        $statusData = [
            ['name' => 'New','icon' => 'fa fa-user-o', 'color' => 'col-orange','system_name'=>'new', 'company_id' => $companyId],
            ['name' => 'Contact in future','icon' => 'fa fa-calendar-o', 'color' => 'col-blue','system_name'=>'contact_in_future', 'company_id' => $companyId],
            ['name' => 'Contacted','icon' => 'fa fa-handshake-o', 'color' => 'col-green','system_name'=>'contacted', 'company_id' => $companyId],
            ['name' => 'Junk lead','icon' => 'fa fa-trash', 'color' => 'col-grey','system_name'=>'junk_lead', 'company_id' => $companyId],
            ['name' => 'Lost lead','icon' => 'fa fa-chain-broken', 'color' => 'col-blue-grey','system_name'=>'lost_lead', 'company_id' => $companyId],
            ['name' => 'Not contacted','icon' => 'fa fa-question-circle', 'color' => 'col-deep-purple','system_name'=>'not_contacted', 'company_id' => $companyId],
            ['name' => 'Pre qualified','icon' => 'fa fa-meh-o', 'color' => 'col-light-green','system_name'=>'pre_qualified', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('leads_dict_status', $statusData);

        $sourcedata = [
            ['name' => 'Advertisement', 'company_id' => $companyId],
            ['name' => 'Cold call', 'company_id' => $companyId],
            ['name' => 'Employee referral', 'company_id' => $companyId],
            ['name' => 'External referral', 'company_id' => $companyId],
            ['name' => 'Partner', 'company_id' => $companyId],
            ['name' => 'Public relations', 'company_id' => $companyId],
            ['name' => 'Trade show', 'company_id' => $companyId],
            ['name' => 'Web form', 'company_id' => $companyId],
            ['name' => 'Search engine', 'company_id' => $companyId],
            ['name' => 'Facebook', 'company_id' => $companyId],
            ['name' => 'Twitter', 'company_id' => $companyId],
            ['name' => 'Online store', 'company_id' => $companyId],
            ['name' => 'Seminar partner', 'company_id' => $companyId],
            ['name' => 'Web download', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('leads_dict_source', $sourcedata);

        $industrydata = [
            ['name' => 'Communucation', 'company_id' => $companyId],
            ['name' => 'Technology', 'company_id' => $companyId],
            ['name' => 'Government military', 'company_id' => $companyId],
            ['name' => 'Manufacturing', 'company_id' => $companyId],
            ['name' => 'Financial services', 'company_id' => $companyId],
            ['name' => 'IT Service', 'company_id' => $companyId],
            ['name' => 'Education', 'company_id' => $companyId],
            ['name' => 'Pharma', 'company_id' => $companyId],
            ['name' => 'Real Estate', 'company_id' => $companyId],
            ['name' => 'Consulting', 'company_id' => $companyId],
            ['name' => 'Health Care', 'company_id' => $companyId],
            ['name' => 'RRP', 'company_id' => $companyId],
            ['name' => 'Service provider', 'company_id' => $companyId],
            ['name' => 'Data telecom', 'company_id' => $companyId],
            ['name' => 'Large enterprise', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('leads_dict_industry', $industrydata);

        $ratingdata = [
            ['name' => 'Acquired', 'company_id' => $companyId],
            ['name' => 'Active', 'company_id' => $companyId],
            ['name' => 'Market failed', 'company_id' => $companyId],
            ['name' => 'Project cancelled', 'company_id' => $companyId],
            ['name' => 'Shut down', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('leads_dict_rating', $ratingdata);

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('leads_dict_status')->truncate();
        DB::table('leads_dict_source')->truncate();
        DB::table('leads_dict_industry')->truncate();
        DB::table('leads_dict_rating')->truncate();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());

    }
}
