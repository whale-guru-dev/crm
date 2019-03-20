<?php

namespace Modules\Documents\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

class DocumentsDatabaseSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {
        $documents_dict_type = [
            ['name' => 'Internal', 'company_id' => $companyId],
            ['name' => 'External', 'company_id' => $companyId],
        ];

        $this->saveOrUpdate('documents_dict_type', $documents_dict_type);

        $documents_dict_category = [
            ['name' => 'Approval', 'company_id' => $companyId],
            ['name' => 'Proposal', 'company_id' => $companyId],
            ['name' => 'Quote', 'company_id' => $companyId],
            ['name' => 'Contract', 'company_id' => $companyId],
            ['name' => 'Invoice', 'company_id' => $companyId],
            ['name' => 'Report', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('documents_dict_category', $documents_dict_category);

        $documents_dict_status = [
            ['name' => 'New', 'company_id' => $companyId],
            ['name' => 'In progress', 'company_id' => $companyId],
            ['name' => 'Approved', 'company_id' => $companyId],
            ['name' => 'Closed', 'company_id' => $companyId],
        ];


        $this->saveOrUpdate('documents_dict_status', $documents_dict_status);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('documents_dict_type')->truncate();
        DB::table('documents_dict_category')->truncate();
        DB::table('documents_dict_status')->truncate();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());


    }
}
