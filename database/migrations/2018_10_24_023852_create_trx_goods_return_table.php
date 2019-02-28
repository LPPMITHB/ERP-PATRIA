<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxGoodsReturnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_goods_return', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->unsignedInteger('business_unit_id');
            $table->unsignedInteger('purchase_order_id')->nullable();
            $table->unsignedInteger('goods_receipt_id')->nullable();
            $table->text('description');
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->integer('status')->default(1);
            $table->unsignedInteger('approved_by')->nullable();
            $table->timestamps();

            $table->foreign('business_unit_id')->references('id')->on('mst_business_unit');
            $table->foreign('purchase_order_id')->references('id')->on('trx_purchase_order');
            $table->foreign('goods_receipt_id')->references('id')->on('trx_goods_receipt');
            $table->foreign('approved_by')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_goods_return');
    }
}
