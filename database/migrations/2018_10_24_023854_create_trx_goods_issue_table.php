<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxGoodsIssueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_goods_issue', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->unsignedInteger('business_unit_id');
            $table->unsignedInteger('material_requisition_id')->nullable();
            $table->unsignedInteger('purchase_order_id')->nullable();
            $table->unsignedInteger('goods_receipt_id')->nullable();
            $table->text('description');
            $table->integer('type')->default(1);
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('business_unit_id')->references('id')->on('mst_business_unit');
            $table->foreign('material_requisition_id')->references('id')->on('trx_material_requisition');
            $table->foreign('purchase_order_id')->references('id')->on('trx_purchase_order');
            $table->foreign('goods_receipt_id')->references('id')->on('trx_goods_receipt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_goods_issue');
    }
}
