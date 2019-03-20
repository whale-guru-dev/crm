<?php

namespace Modules\Tickets\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class TicketsDatabaseSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {

        $dictValues = [
            ['name' => 'Big problem', 'company_id' => $companyId],
            ['name' => 'Small problem', 'company_id' => $companyId],
            ['name' => 'Other problem', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('tickets_dict_category', $dictValues);

        $dictValues = [
            [ 'name' => 'Low','color' => 'col-grey', 'company_id' => $companyId],
            [ 'name' => 'Normal','color' => 'col-green', 'company_id' => $companyId],
            [ 'name' => 'High','color' => 'col-orange', 'company_id' => $companyId],
            [ 'name' => 'Urgent','color' => 'col-red', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('tickets_dict_priority', $dictValues);


        $dictValues = [
            [ 'name' => 'Minor','color' => 'col-light-green', 'company_id' => $companyId],
            [ 'name' => 'Major','color' => 'col-green', 'company_id' => $companyId],
            [ 'name' => 'Feature', 'color' => 'col-orange', 'company_id' => $companyId],
            [ 'name' => 'Critical','color' => 'col-red', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('tickets_dict_severity', $dictValues);


        $dictValues = [
            [ 'name' => 'New','system_name'=>'new', 'company_id' => $companyId],
            [ 'name' => 'In progress','system_name'=>'in_progress', 'company_id' => $companyId],
            [ 'name' => 'Wait for response','system_name'=>'wait_for_response', 'company_id' => $companyId],
            [ 'name' => 'Closed','system_name'=>'closed', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('tickets_dict_status', $dictValues);

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('tickets_dict_category')->truncate();
        DB::table('tickets_dict_priority')->truncate();
        DB::table('tickets_dict_severity')->truncate();
        DB::table('tickets_dict_status')->truncate();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());


    }
}
