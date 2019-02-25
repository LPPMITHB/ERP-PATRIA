<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxGoodsReturnDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_goods_return_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('goods_return_id');
            $table->integer('quantity');
            $table->unsignedInteger('material_id')->nullable();
            $table->unsignedInteger('resource_detail_id')->nullable();
            $table->unsignedInteger('storage_location_id')->nullable();
            $table->timestamps();

            $table->foreign('storage_location_id')->references('id')->on('mst_storage_location'); 
            $table->foreign('resource_detail_id')->references('id')->on('mst_resource_detail'); 
            $table->foreign('goods_return_id')->references('id')->on('trx_goods_return');
            $table->foreign('material_id')->references('id')->on('mst_material');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_goods_return_detail');
    }
}
