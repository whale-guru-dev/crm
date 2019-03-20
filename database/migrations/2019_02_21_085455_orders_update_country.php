<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersUpdateCountry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn('bill_country');
            $table->dropColumn('ship_country');

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
        Schema::table('quotes', function (Blueprint $table) {

            $table->string('bill_country')->nullable();
            $table->string('ship_country')->nullable();

            $table->dropColumn('bill_country_id');
            $table->dropColumn('ship_country_id');

        });
    }
}
