<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProWbsImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_wbs_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wbs_id');
            $table->string('drawing');
            $table->string('description')->nullable();

            $table->foreign('wbs_id')->references('id')->on('pro_wbs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
