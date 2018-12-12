<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstBosDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_bos_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bos_id')->nullable();
            $table->unsignedInteger('material_id')->nullable();
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('bos_id')->references('id')->on('mst_bos');
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
        Schema::dropIfExists('mst_bos_detail');
    }
}
