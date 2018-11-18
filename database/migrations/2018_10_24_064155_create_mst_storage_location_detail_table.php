<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstStorageLocationDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_storage_location_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('material_id');
            $table->integer('quantity');
            $table->integer('reserved')->default(0);
            $table->unsignedInteger('storage_location_id')->nullable();
            $table->timestamps();
            
            $table->foreign('storage_location_id')->references('id')->on('mst_storage_location'); 
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
        Schema::dropIfExists('mst_storage_location_detail');
    }
}
