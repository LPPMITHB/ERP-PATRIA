<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxRapDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_rap_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rap_id');
            $table->unsignedInteger('material_id')->nullable();
            $table->unsignedInteger('service_id')->nullable();
            $table->integer('quantity');
            $table->double('price');
            $table->timestamps();
    
            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('service_id')->references('id')->on('mst_service');
            $table->foreign('rap_id')->references('id')->on('trx_rap');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_rap_detail');
    }
}
