<?php

namespace Modules\Assets\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class AssetsDatabaseSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {

        $assets_dict_category = [
            ['name' => 'Phone', 'company_id' => $companyId],
            ['name' => 'Computer', 'company_id' => $companyId],
            ['name' => 'License', 'company_id' => $companyId],
            ['name' => 'Car', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('assets_dict_category', $assets_dict_category);

        $assets_dict_manufacturer = [
            ['name' => 'Apple', 'company_id' => $companyId],
            ['name' => 'Samsung', 'company_id' => $companyId],
            ['name' => 'Toyota', 'company_id' => $companyId],
            ['name' => 'Skoda', 'company_id' => $companyId],
            ['name' => 'Nokia', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('assets_dict_manufacturer', $assets_dict_manufacturer);

        $assets_dict_status = [
            ['name' => 'Ready to deploy', 'company_id' => $companyId],
            ['name' => 'Deployed', 'company_id' => $companyId],
            ['name' => 'Pending', 'company_id' => $companyId],
            ['name' => 'Out for repair', 'company_id' => $companyId],
            ['name' => 'Out for diagnostics', 'company_id' => $companyId],
            ['name' => 'Broken not fixable', 'company_id' => $companyId],
            ['name' => 'Lost/stolen', 'company_id' => $companyId],
            ['name' => 'On order', 'company_id' => $companyId],
            ['name' => 'In stock', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('assets_dict_status', $assets_dict_status);

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('assets_dict_category')->truncate();
        DB::table('assets_dict_manufacturer')->truncate();
        DB::table('assets_dict_status')->truncate();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());


    }
}
