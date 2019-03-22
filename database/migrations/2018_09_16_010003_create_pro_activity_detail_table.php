<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProActivityDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_activity_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('activity_id');
            $table->unsignedInteger('material_id')->nullable();
            $table->unsignedInteger('service_detail_id')->nullable();
            $table->unsignedInteger('vendor_id')->nullable();
            $table->integer('quantity_material')->nullable();
            $table->float('length', 15, 2)->nullable();
            $table->float('width', 15, 2)->nullable();
            $table->float('height', 15, 2)->nullable();
            $table->float('weight', 15, 2)->nullable();
            $table->unsignedInteger('dimension_uom_id')->nullable();
            $table->float('area', 15, 2)->nullable();
            $table->unsignedInteger('area_uom_id')->nullable();
            $table->unsignedInteger('bom_prep_id')->nullable();
            $table->string('source')->nullable();
            $table->timestamps();

            $table->foreign('activity_id')->references('id')->on('pro_activity');
            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('service_detail_id')->references('id')->on('mst_service_detail');
            $table->foreign('vendor_id')->references('id')->on('mst_vendor');
            $table->foreign('dimension_uom_id')->references('id')->on('mst_uom');
            $table->foreign('area_uom_id')->references('id')->on('mst_uom');
            $table->foreign('bom_prep_id')->references('id')->on('mst_bom_prep');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pro_activity_detail');
    }
}
