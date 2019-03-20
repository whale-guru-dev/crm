<?php

namespace Modules\Payments\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class PaymentsDatatableSeeder extends SeederHelper
{
    public function dictionary($companyId)
    {

        $statusData = [
            ['name' => 'Submitted', 'company_id' => $companyId],
            ['name' => 'Approved', 'company_id' => $companyId],
            ['name' => 'Declined', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('payments_dict_status', $statusData);

        $categoryData = [
            ['name' => 'Gas', 'company_id' => $companyId],
            ['name' => 'Travel', 'company_id' => $companyId],
            ['name' => 'Meals', 'company_id' => $companyId],
            ['name' => 'Car rental', 'company_id' => $companyId],
            ['name' => 'Cell phone', 'company_id' => $companyId],
            ['name' => 'Groceries', 'company_id' => $companyId],
            ['name' => 'Invoice', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('payments_dict_category', $categoryData);

        $paymentMethodData = [
            ['name' => 'Cash', 'company_id' => $companyId],
            ['name' => 'Cheque', 'company_id' => $companyId],
            ['name' => 'Credit card', 'company_id' => $companyId],
            ['name' => 'Direct debit', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('payments_dict_payment_method', $paymentMethodData);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('payments_dict_status')->truncate();
        DB::table('payments_dict_category')->truncate();
        DB::table('payments_dict_payment_method')->truncate();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());
    }
}
