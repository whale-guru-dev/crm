<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoicesUpdateCountry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {

            $table->dropColumn('from_country');
            $table->dropColumn('bill_country');
            $table->dropColumn('ship_country');

            $table->integer('from_country_id')->unsigned()->nullable();
            $table->foreign('from_country_id')->references('id')->on('bap_country');

            $table->integer('bill_country_id')->unsigned()->nullable();
            $table->foreign('bill_country_id')->references('id')->on('bap_country');

            $table->integer('ship_country_id')->unsigned()->nullable();
            $table->foreign('ship_country_id')->references('id')->on('bap_country');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {

            $table->string('from_country')->nullable();
            $table->string('bill_country')->nullable();
            $table->string('ship_country')->nullable();

            $table->dropColumn('from_country_id');
            $table->dropColumn('bill_country_id');
            $table->dropColumn('ship_country_id');

        });
    }
}
