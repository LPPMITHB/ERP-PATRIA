<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxProductionOrderReturnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_production_order_return', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->unsignedInteger('bom_detail_id');
            $table->unsignedInteger('production_order_detail_id');
            $table->unsignedInteger('material_id');
            $table->unsignedInteger('storage_location_id');
            $table->unsignedInteger('goods_receipt_detail_id');
            $table->float('quantity',15,2)->nullable();
            $table->timestamps();

            $table->foreign('bom_detail_id')->references('id')->on('mst_bom_detail');
            $table->foreign('production_order_detail_id')->references('id')->on('trx_production_order_detail');
            $table->foreign('goods_receipt_detail_id')->references('id')->on('trx_goods_receipt_detail');
            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('storage_location_id')->references('id')->on('mst_storage_location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_production_order_return');
    }
}
