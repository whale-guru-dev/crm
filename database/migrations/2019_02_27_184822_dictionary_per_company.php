<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DictionaryPerCompany extends Migration
{

    private $tables = [
        'campaigns_dict_status',
        'campaigns_dict_type',

        'accounts_dict_industry',
        'accounts_dict_rating',
        'accounts_dict_type',
        'assets_dict_category',
        'assets_dict_manufacturer',
        'assets_dict_status',
        'bap_calendar_dict_event_priority',
        'bap_calendar_dict_event_status',
        'calls_dict_direction',
        'contact_request_dict_contact_reason',
        'contact_request_dict_contact_status',
        'contact_request_dict_contact_method',
        'contacts_dict_source',
        'contacts_dict_status',
        'customer_dict_language',
        'deals_dict_business_type',
        'deals_dict_stage',
        'documents_dict_category',
        'documents_dict_status',
        'documents_dict_type',
        'invoices_dict_status',
        'leads_dict_industry',
        'leads_dict_rating',
        'leads_dict_source',
        'leads_dict_status',
        'orders_dict_carrier',
        'orders_dict_status',
        'payments_dict_category',
        'payments_dict_payment_method',
        'payments_dict_status',
        'products_dict_category',
        'products_dict_type',
        'quotes_dict_carrier',
        'quotes_dict_stage',
        'service_contracts_dict_priority',
        'service_contracts_dict_status',
        'tickets_dict_category',
        'tickets_dict_severity',
        'tickets_dict_status',
        'vendors_dict_category',
        'tickets_dict_priority',
        'bap_country',
        'bap_currency',
        'bap_tax',
        'roles'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $table){
            Schema::table($table, function (Blueprint $table) {
                $table->integer('company_id')->nullable();
            });
        }

        Schema::table('tickets_dict_priority', function (Blueprint $table) {
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
        });

        Schema::table('tickets_dict_severity', function (Blueprint $table) {
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        foreach ($this->tables as $table){
            Schema::table($table, function (Blueprint $table) {
                $table->drop('company_id');
            });
        }

        Schema::table('tickets_dict_priority', function (Blueprint $table) {
            $table->dropColumn('color');
            $table->dropColumn('icon');
        });

        Schema::table('tickets_dict_severity', function (Blueprint $table) {
            $table->dropColumn('color');
            $table->dropColumn('icon');
        });
    }
}
