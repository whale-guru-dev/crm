<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixDashboardDicts extends Migration
{

    private $tables = [
        'leads_dict_status',
        'contacts_dict_status',
        'orders_dict_status',
        'invoices_dict_status',
        'tickets_dict_status'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $table) {

            Schema::table($table, function (Blueprint $table) {
                $table->string('system_name')->nullable();
            });

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $table) {

            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('system_name');
            });

        }
    }
}
