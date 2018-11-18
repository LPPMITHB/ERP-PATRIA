<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstBomDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_bom_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bom_id')->nullable();
            $table->unsignedInteger('material_id')->nullable();
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('bom_id')->references('id')->on('mst_bom');
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
        Schema::dropIfExists('mst_bom_detail');
    }
}
