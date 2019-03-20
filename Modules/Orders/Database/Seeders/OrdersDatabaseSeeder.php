<?php

namespace Modules\Orders\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class OrdersDatabaseSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {

        $dictValues = [
            ['name' => 'FedEx', 'company_id' => $companyId],
            ['name' => 'UPS', 'company_id' => $companyId],
            ['name' => 'USPS', 'company_id' => $companyId],
            ['name' => 'DHL', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('orders_dict_carrier', $dictValues);

        $dictValues = [
            ['name' => 'Created','system_name'=>'created', 'company_id' => $companyId],
            ['name' => 'Approved','system_name'=>'approved', 'company_id' => $companyId],
            ['name' => 'Delivered','system_name'=>'delivered', 'company_id' => $companyId],
            ['name' => 'Cancelled','system_name'=>'cancelled', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('orders_dict_status', $dictValues);

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('orders_dict_carrier')->truncate();
        DB::table('orders_dict_status')->truncate();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());


    }
}
