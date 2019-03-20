<?php

namespace Modules\Invoices\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class InvoicesDatabaseSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {

        $dictValues = [
            ['name' => 'Created','system_name'=>'created', 'company_id' => $companyId],
            ['name' => 'Cancel','system_name'=>'canceled','company_id' => $companyId],
            ['name' => 'Approved','system_name'=>'approved', 'company_id' => $companyId],
            ['name' => 'Sent','system_name'=>'sent', 'company_id' => $companyId],
            ['name' => 'Paid','system_name'=>'paid', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('invoices_dict_status', $dictValues);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('invoices_dict_status')->truncate();


        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());
    }
}
