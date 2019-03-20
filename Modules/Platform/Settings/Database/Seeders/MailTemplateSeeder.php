<?php

namespace Modules\Platform\Settings\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\SeederHelper;

/**
 * Class MailTemplateSeeder
 * @package Modules\Platform\Settings\Database\Seeders
 */
class MailTemplateSeeder extends SeederHelper
{

    public function dictionary($companyId)
    {

        $taxData = [
            ['company_id' => $companyId, 'name' => 'Welcome Mail', 'subject' => "Welcome to the family!",'message' => '<p>Hi {{first_name}} <br><br>Thanks for signing up ...., the advanced multicrm.</p><p><br></p><p>Here you can start and learn more information about crm -&nbsp;<a href="https://laravel-bap.com/doc/laravel-bap-crm/#1344">https://laravel-bap.com/doc/laravel-bap-crm/#1344</a>&nbsp;</p><p><br></p><p>Let me know if you have any questions, feedback or ideas -- just reply to this email!</p><p><br></p><p><br></p>'],
            ['company_id' => $companyId, 'name' => 'Latest Naruto Ninja Video ', 'subject' => 'Latest Naruto Ninja Video', 'message' => '<p>Omg, omg, omg!</p><p><br>check this! this is latest neuro ninja video!&nbsp;</p><p><a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">https://www.youtube.com/watch?v=dQw4w9WgXcQ</a>&nbsp;</p><p><br>You Need to Watch this</p><p><br></p>']
        ];

        $this->saveOrUpdate('bap_email_template', $taxData);

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('emails')->truncate();
        DB::table('bap_email_template')->truncate();

        Model::unguard();

        $this->dictionary($this->firstCompany());
        $this->dictionary($this->secondCompany());

    }
}
