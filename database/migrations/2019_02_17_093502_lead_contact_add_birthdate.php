<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeadContactAddBirthdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->date('birth_date')->nullable();
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->date('birth_date')->nullable();
        });
    }

    /**`
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('birth_date');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('birth_date');
        });
    }
}
