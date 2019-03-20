<?php

namespace Modules\Calendar\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class CalendarDatabaseSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {
        $bap_calendar_dict_event_priority = [
            ['name' => 'Low', 'company_id' => $companyId],
            ['name' => 'Normal', 'company_id' => $companyId],
            ['name' => 'High', 'company_id' => $companyId],
            ['name' => 'Urgent', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('bap_calendar_dict_event_priority', $bap_calendar_dict_event_priority);

        $bap_calendar_dict_event_status = [
            ['name' => 'New', 'company_id' => $companyId],
            ['name' => 'In progress', 'company_id' => $companyId],
            ['name' => 'On hold', 'company_id' => $companyId],
            ['name' => 'Complete', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('bap_calendar_dict_event_status', $bap_calendar_dict_event_status);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('bap_calendar_dict_event_priority')->truncate();
        DB::table('bap_calendar_dict_event_status')->truncate();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());


    }
}
