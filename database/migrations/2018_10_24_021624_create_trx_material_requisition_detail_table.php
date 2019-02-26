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
            $table->float('quantity',15,2);
            $table->float('issued',15,2)->default(0);
            $table->unsignedInteger('material_id');
            $table->unsignedInteger('wbs_id')->nullable();
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('wbs_id')->references('id')->on('pro_wbs');
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
