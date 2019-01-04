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
            // $table->unsignedInteger('work_order_id');
            $table->unsignedInteger('material_requisition_id')->nullable();
            $table->string('description');
            $table->integer('status')->default(1);
            $table->integer('type')->default(1);
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('material_requisition_id')->references('id')->on('trx_material_requisition');
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
