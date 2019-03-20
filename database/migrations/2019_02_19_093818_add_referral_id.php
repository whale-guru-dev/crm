<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferralId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('leads', function (Blueprint $table) {

            $table->unsignedInteger('referral_id')->nullable();
            $table->foreign('referral_id')->references('id')->on('leads')->onDelete('cascade');

        });

        Schema::table('contacts', function (Blueprint $table) {

            $table->unsignedInteger('referral_id')->nullable();
            $table->foreign('referral_id')->references('id')->on('contacts')->onDelete('cascade');

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
            $table->dropColumn('referral_id');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('referral_id');
        });
    }
}
