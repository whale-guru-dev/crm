<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bap_country', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('alpha2')->nullable();
            $table->string('alpha3')->nullable();
            $table->string('continent')->nullable();
            $table->boolean('is_active',true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bap_country');
    }
}
