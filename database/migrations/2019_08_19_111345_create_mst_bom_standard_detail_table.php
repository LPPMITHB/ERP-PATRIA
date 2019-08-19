<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstBomStandardDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_bom_standard_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bom_standard_id');
            $table->unsignedInteger('material_id')->nullable();
            $table->float('quantity',15,2);
            $table->string('source')->default('Stock');
            $table->timestamps();

            $table->foreign('bom_standard_id')->references('id')->on('mst_bom_standard');
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
        Schema::dropIfExists('mst_bom_standard_detail');
    }
}
