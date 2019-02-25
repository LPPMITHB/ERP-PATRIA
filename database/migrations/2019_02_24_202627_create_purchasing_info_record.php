<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasingInfoRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasing_info_record', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('purchase_order_id');
            $table->unsignedInteger('purchase_order_detail_id');
            $table->unsignedInteger('material_id')->nullable();
            $table->unsignedInteger('resource_id')->nullable();
            $table->unsignedInteger('vendor_id')->nullable();
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('resource_id')->references('id')->on('mst_resource');
            $table->foreign('vendor_id')->references('id')->on('mst_vendor');
            $table->foreign('purchase_order_id')->references('id')->on('trx_purchase_order');
            $table->foreign('purchase_order_detail_id')->references('id')->on('trx_purchase_order_detail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchasing_info_record');
    }
}
