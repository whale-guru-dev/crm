<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeadContactAddLanguage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('customer_dict_language', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('leads', function (Blueprint $table) {

            $table->unsignedInteger('language_id')->nullable();

            $table->foreign('language_id')->references('id')->on('customer_dict_language')->onDelete('cascade');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->unsignedInteger('language_id')->nullable();

            $table->foreign('language_id')->references('id')->on('customer_dict_language')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_dict_language');

        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('language_id');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('language_id');
        });



    }
}
