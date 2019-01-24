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
            $table->integer('quantity');
            $table->integer('received')->default(0);
            $table->integer('returned')->default(0);
            $table->unsignedInteger('material_id')->nullable();
            $table->unsignedInteger('resource_id')->nullable();
            $table->unsignedInteger('wbs_id')->nullable();
            $table->double('total_price')->nullable();
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('resource_id')->references('id')->on('mst_resource');
            $table->foreign('purchase_order_id')->references('id')->on('trx_purchase_order');
            $table->foreign('purchase_requisition_detail_id')->references('id')->on('trx_purchase_requisition_detail');
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
        Schema::dropIfExists('trx_purchase_order_detail');
    }
}
