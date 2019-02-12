<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxWorkRequestDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_work_request_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('work_request_id');
            $table->date('required_date')->nullable();
            $table->integer('quantity');
            $table->integer('reserved')->default(0);            
            $table->text('description')->nullable();
            $table->integer('type');
            $table->unsignedInteger('material_id')->nullable();
            $table->unsignedInteger('wbs_id')->nullable();
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('wbs_id')->references('id')->on('pro_wbs');
            $table->foreign('work_request_id')->references('id')->on('trx_work_request');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_work_request_detail');
    }
}
