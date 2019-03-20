<?php

namespace Modules\Products\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class ProductsDatabaseSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {

        $dictValues = [
            ['name' => 'Hardware', 'company_id' => $companyId],
            ['name' => 'Software', 'company_id' => $companyId],
            ['name' => 'Other', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('products_dict_category', $dictValues);


        $dictValues = [
            ['name' => 'Product', 'company_id' => $companyId],
            ['name' => 'Service', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('products_dict_type', $dictValues);

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('products_dict_category')->truncate();
        DB::table('products_dict_type')->truncate();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());
    }
}
