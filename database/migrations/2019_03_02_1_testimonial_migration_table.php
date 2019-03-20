<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TestimonialMigrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('testimonials', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('product_id')->unsigned()->nullable();

            $table->integer('contact_id')->unsigned()->nullable();

            $table->integer('company_id')->nullable();

            $table->text('comment')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('testimonials', function (Blueprint $table) {

            $table->foreign('product_id')->references('id')->on('products');

            $table->foreign('contact_id')->references('id')->on('contacts');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('testimonials');
    }
}
