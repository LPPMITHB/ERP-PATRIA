<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxGoodsMovementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_goods_movement_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('goods_movement_id');
            $table->unsignedInteger('material_id');
            $table->float('quantity',15,2);
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('goods_movement_id')->references('id')->on('trx_goods_movement');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_goods_movement_detail');
    }
}
