<?php

namespace Modules\Campaigns\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class CampaignsDatabaseSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {

        Model::unguard();

        $campaigns_dict_status = [
            ['name' => 'Planning', 'icon' => 'fa fa-pause-circle-o', 'color' => 'col-grey', 'company_id' => $companyId],
            ['name' => 'Active', 'icon' => 'fa fa-play-circle', 'color' => 'col-green', 'company_id' => $companyId],
            ['name' => 'Inactive', 'icon' => 'fa fa-stop-circle', 'color' => 'col-brown', 'company_id' => $companyId],
            ['name' => 'Completed', 'icon' => 'fa fa-pie-chart', 'color' => 'col-light-green', 'company_id' => $companyId],
            ['name' => 'Cancelled', 'icon' => 'fa fa-trash', 'color' => 'col-red', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('campaigns_dict_status', $campaigns_dict_status);

        $campaigns_dict_type = [
            ['name' => 'Conference', 'company_id' => $companyId],
            ['name' => 'Webinar', 'company_id' => $companyId],
            ['name' => 'Trade show', 'company_id' => $companyId],
            ['name' => 'Public relations', 'company_id' => $companyId],
            ['name' => 'Partners', 'company_id' => $companyId],
            ['name' => 'Referral program', 'company_id' => $companyId],
            ['name' => 'Advertisement', 'company_id' => $companyId],
            ['name' => 'Banner ads', 'company_id' => $companyId],
            ['name' => 'Direct mail', 'company_id' => $companyId],
            ['name' => 'Telemarketing', 'company_id' => $companyId],
            ['name' => 'Others', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('campaigns_dict_type', $campaigns_dict_type);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('campaigns_dict_status')->truncate();
        DB::table('campaigns_dict_type')->truncate();


        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());


    }
}
