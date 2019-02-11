<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxGoodsReceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_goods_receipt', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->unsignedInteger('business_unit_id');
            $table->unsignedInteger('purchase_order_id')->nullable();
            $table->unsignedInteger('work_order_id')->nullable();
            $table->unsignedInteger('vendor_id')->nullable();
            $table->date('ship_date')->nullable();
            $table->text('description');
            $table->integer('type');
            $table->integer('status')->default(1);
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('purchase_order_id')->references('id')->on('trx_purchase_order');
            $table->foreign('work_order_id')->references('id')->on('trx_work_order');
            $table->foreign('vendor_id')->references('id')->on('mst_vendor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_goods_receipt');
    }
}
