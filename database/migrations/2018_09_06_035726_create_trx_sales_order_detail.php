<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxSalesOrderDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_sales_order_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sales_order_id');
            $table->unsignedInteger('cost_standard_id');
            $table->float('value',15,2)->default(0);
            $table->bigInteger('price')->default(0);
            $table->timestamps();
            
            $table->foreign('sales_order_id')->references('id')->on('trx_sales_order');
            $table->foreign('cost_standard_id')->references('id')->on('mst_estimator_cost_standard');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_sales_order_detail');
    }
}
