<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxPurchaseOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_purchase_order_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('purchase_order_id');
            $table->unsignedInteger('purchase_requisition_detail_id')->nullable();
            $table->float('discount')->default(0);
            $table->integer('quantity');
            $table->integer('received')->default(0);
            $table->integer('returned')->default(0);
            $table->text('remark')->nullable();
            $table->unsignedInteger('material_id')->nullable();
            $table->unsignedInteger('resource_id')->nullable();
            $table->unsignedInteger('project_id')->nullable();
            $table->double('total_price')->nullable();
            $table->date('delivery_date');
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('resource_id')->references('id')->on('mst_resource');
            $table->foreign('purchase_order_id')->references('id')->on('trx_purchase_order');
            $table->foreign('purchase_requisition_detail_id')->references('id')->on('trx_purchase_requisition_detail');
            $table->foreign('project_id')->references('id')->on('pro_project');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_purchase_order_detail');
    }
}
