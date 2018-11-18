<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxMaterialRequisitionDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_material_requisition_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('material_requisition_id');
            $table->integer('quantity');
            $table->integer('issued')->default(0);
            $table->unsignedInteger('material_id');
            $table->unsignedInteger('work_id')->nullable();
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('work_id')->references('id')->on('pro_project_work');
            $table->foreign('material_requisition_id')->references('id')->on('trx_material_requisition');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_material_requisition_detail');
    }
}
