<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxMaterialWriteOffDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_material_write_off_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('material_write_off_id');
            $table->float('quantity',15,2);
            $table->double('amount');
            $table->text('remark')->nullable();
            $table->unsignedInteger('material_id')->nullable();
            $table->unsignedInteger('storage_location_id')->nullable();
            $table->timestamps();

            $table->foreign('storage_location_id')->references('id')->on('mst_storage_location'); 
            $table->foreign('material_write_off_id')->references('id')->on('trx_material_write_off');
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
        Schema::dropIfExists('trx_material_write_off_detail');
    }
}
