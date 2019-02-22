<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxPurchaseRequisitionDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_purchase_requisition_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('purchase_requisition_id');
            $table->date('required_date')->nullable();
            $table->integer('quantity');
            $table->integer('reserved')->default(0);
            $table->unsignedInteger('material_id')->nullable();
            $table->unsignedInteger('resource_id')->nullable();
            $table->string('alocation')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('project_id')->nullable();
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('resource_id')->references('id')->on('mst_resource');
            $table->foreign('purchase_requisition_id')->references('id')->on('trx_purchase_requisition');
            $table->foreign('project_id')->references('id')->on('pro_project');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_purchase_requisition_detail');
    }
}
