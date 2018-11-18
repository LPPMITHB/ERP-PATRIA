<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxGoodsIssueDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_goods_issue_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('goods_issue_id');
            $table->integer('quantity');
            $table->unsignedInteger('material_id');
            $table->unsignedInteger('storage_location_id');
            $table->timestamps();

            $table->foreign('storage_location_id')->references('id')->on('mst_storage_location'); 
            $table->foreign('goods_issue_id')->references('id')->on('trx_goods_issue');
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
        Schema::dropIfExists('trx_goods_issue_detail');
    }
}
