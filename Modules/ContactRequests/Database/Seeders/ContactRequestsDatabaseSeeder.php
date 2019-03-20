<?php

namespace Modules\ContactRequests\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class ContactRequestsDatabaseSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {

        $dictValues = [
            ['name' => 'Want to know more about product', 'company_id' => $companyId],
            ['name' => 'Interested in partnership', 'company_id' => $companyId],
            ['name' => 'Need help or assistance', 'company_id' => $companyId],
            ['name' => 'Have a complaint', 'company_id' => $companyId],
            ['name' => 'Other', 'company_id' => $companyId],
        ];

        DB::table('contact_request_dict_contact_reason')->insert($dictValues);

        $dictValues = [
            ['name' => 'New', 'company_id' => $companyId],
            ['name' => 'In-progress', 'company_id' => $companyId],
            ['name' => 'Contacted', 'company_id' => $companyId],
            ['name' => 'Contact in future', 'company_id' => $companyId],
            ['name' => 'Win', 'company_id' => $companyId],
            ['name' => 'Lost', 'company_id' => $companyId],
        ];

        DB::table('contact_request_dict_contact_status')->insert($dictValues);

        $dictValues = [
            ['name' => 'Phone', 'company_id' => $companyId],
            ['name' => 'E-mail', 'company_id' => $companyId],
            ['name' => 'Other', 'company_id' => $companyId],
        ];

        DB::table('contact_request_dict_contact_method')->insert($dictValues);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('contact_request_dict_contact_reason')->truncate();
        DB::table('contact_request_dict_contact_status')->truncate();
        DB::table('contact_request_dict_contact_method')->truncate();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());
    }
}
