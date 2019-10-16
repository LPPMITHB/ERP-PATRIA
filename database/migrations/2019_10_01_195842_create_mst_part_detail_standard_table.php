<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstPartDetailStandardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_part_detail_standard', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->unsignedInteger('material_standard_id')->nullable();
            $table->longText('dimensions_value')->nullable();
            $table->float('weight', 15, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->unsignedInteger('service_id')->nullable();
            $table->unsignedInteger('service_detail_id')->nullable();

            $table->timestamps();
            $table->foreign('material_standard_id')->references('id')->on('mst_material_standard');
            $table->foreign('service_id')->references('id')->on('mst_service');
            $table->foreign('service_detail_id')->references('id')->on('mst_service_detail');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_part_detail_standard');
    }
}
