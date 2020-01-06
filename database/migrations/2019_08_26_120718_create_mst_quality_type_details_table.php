<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstQualityTypeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_quality_control_type_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quality_control_type_id');//group dari tugasnya
            $table->string('name');//nama tugasnya 
            $table->text('task_description')->nullable(); //disuruh ngapain sih tugasnya
            $table->string('acceptance_value')->nullable(); //value lolos quality controlnya berapa ?

            $table->timestamps();

            $table->foreign('quality_control_type_id')->references('id')->on('mst_quality_control_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_quality_type_details');
    }
}
