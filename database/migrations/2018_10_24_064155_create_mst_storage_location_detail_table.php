<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstStorageLocationDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_storage_location_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('material_id');
            $table->float('quantity',15,2);
            $table->double('value')->nullable();
            $table->unsignedInteger('goods_receipt_detail_id')->nullable();
            $table->unsignedInteger('storage_location_id')->nullable();
            $table->timestamps();
            
            $table->foreign('goods_receipt_detail_id')->references('id')->on('trx_goods_receipt_detail'); 
            $table->foreign('storage_location_id')->references('id')->on('mst_storage_location'); 
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
        Schema::dropIfExists('mst_storage_location_detail');
    }
}
