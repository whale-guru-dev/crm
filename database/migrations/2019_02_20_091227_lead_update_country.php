<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LeadUpdateCountry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {

            $table->dropColumn('addr_country');
            $table->integer('addr_country_id')->unsigned()->nullable();
            $table->foreign('addr_country_id')->references('id')->on('bap_country');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {

            $table->string('addr_country')->nullable();
            $table->dropColumn('addr_country_id');
        });
    }
}
