<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefSnapshotDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_snapshot_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('snapshot_id');
            $table->unsignedInteger('material_id');
            $table->unsignedInteger('storage_location_id');
            $table->float('count',15,2)->nullable();
            $table->float('quantity',15,2);
            $table->float('adjusted_stock',15,2)->nullable();
            $table->timestamps();
             
            $table->foreign('storage_location_id')->references('id')->on('mst_storage_location'); 
            $table->foreign('snapshot_id')->references('id')->on('ref_snapshot');
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
        Schema::dropIfExists('ref_snapshot_detail');
    }
}
