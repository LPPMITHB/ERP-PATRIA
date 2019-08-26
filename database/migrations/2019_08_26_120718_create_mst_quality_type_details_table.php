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
        Schema::create('mst_quality_type_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('qctype_id');
            $table->integer('position');
            $table->string('name');
            $table->text('description')->nullable();
            
            $table->timestamps();

            $table->foreign('qctype_id')->references('id')->on('mst_quality_types');
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
