<?php

namespace Modules\Platform\Settings\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

/**
 * Class SettingsTimeFormatSeeder
 */
class TaxSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {

        $taxData = [
            ['name' => '23%', 'tax_value' => 0.23, 'company_id' => $companyId],
            ['name' => '8%', 'tax_value' => 0.08, 'company_id' => $companyId],
            ['name' => '5%', 'tax_value' => 0.05, 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('bap_tax', $taxData);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('bap_tax')->truncate();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());

    }
}
