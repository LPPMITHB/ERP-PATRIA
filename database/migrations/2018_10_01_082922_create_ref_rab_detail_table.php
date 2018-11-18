<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefRabDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_rab_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rab_id');
            $table->unsignedInteger('bom_id');
            $table->unsignedInteger('material_id');
            $table->integer('quantity');
            $table->bigInteger('price');
            $table->timestamps();
    
            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('bom_id')->references('id')->on('mst_bom');
            $table->foreign('rab_id')->references('id')->on('ref_rab');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_rab_detail');
    }
}
