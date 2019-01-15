<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxWorkOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_work_order_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('work_order_id');
            $table->unsignedInteger('work_request_detail_id')->nullable();
            $table->integer('quantity');
            $table->float('discount')->default(0);
            $table->unsignedInteger('material_id')->nullable();
            $table->unsignedInteger('resource_id')->nullable();
            $table->unsignedInteger('wbs_id')->nullable();
            $table->double('total_price')->nullable();
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('work_order_id')->references('id')->on('trx_work_order');
            $table->foreign('work_request_detail_id')->references('id')->on('trx_work_request_detail');
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
        Schema::dropIfExists('trx_work_order_detail');
    }
}
