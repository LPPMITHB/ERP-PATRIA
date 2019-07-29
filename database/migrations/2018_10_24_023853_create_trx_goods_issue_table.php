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
            $table->unsignedInteger('goods_return_id')->nullable();
            $table->unsignedInteger('material_write_off_id')->nullable();
            $table->date('issue_date')->nullable();
            $table->text('description');
            $table->integer('status')->default(1);
            $table->integer('type')->default(1);
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('approved_by')->nullable();
            $table->timestamps();

            $table->foreign('business_unit_id')->references('id')->on('mst_business_unit');
            $table->foreign('material_requisition_id')->references('id')->on('trx_material_requisition');
            $table->foreign('goods_return_id')->references('id')->on('trx_goods_return');
            $table->foreign('material_write_off_id')->references('id')->on('trx_material_write_off');
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
