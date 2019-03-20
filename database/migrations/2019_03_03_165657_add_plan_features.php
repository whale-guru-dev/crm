<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bap_companies_plan', function (Blueprint $table) {

            $table->increments('id');

            $table->string('name')->nullable();

            $table->string('api_name')->nullable()->unique();

            $table->text('description')->nullable();

            $table->timestamps();
        });

        Schema::table('bap_companies', function (Blueprint $table) {
            $table->integer('plan_id')->unsigned()->nullable();
            $table->foreign('plan_id')->references('id')->on('bap_companies_plan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bap_companies_plan');

        Schema::table('bap_companies', function (Blueprint $table) {
            $table->drop('plan_id');
        });
    }
}
