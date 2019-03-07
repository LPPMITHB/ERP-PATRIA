<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProActivityDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_activity_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('activity_id')->nullable();
            $table->unsignedInteger('material_id')->nullable();
            $table->unsignedInteger('service_id')->nullable();
            $table->integer('quantity_material')->nullable();
            $table->integer('quantity_service')->nullable();
            $table->float('length', 15, 2)->nullable();
            $table->integer('length_uom_id')->nullable();
            $table->float('width', 15, 2)->nullable();
            $table->integer('width_uom_id')->nullable();
            $table->float('height', 15, 2)->nullable();
            $table->integer('height_uom_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pro_activity_detail');
    }
}
