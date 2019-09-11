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
            $table->unsignedInteger('quality_control_type_id');
            $table->string('name');
            $table->text('description')->nullable();
            
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
