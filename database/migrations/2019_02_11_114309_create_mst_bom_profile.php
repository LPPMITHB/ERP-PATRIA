<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstBomProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_bom_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wbs_id');
            $table->unsignedInteger('material_id')->nullable();
            $table->unsignedInteger('service_id')->nullable();
            $table->integer('quantity');
            $table->string('source')->default('Stock');
            $table->timestamps();

            $table->foreign('wbs_id')->references('id')->on('mst_wbs_profile');
            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('service_id')->references('id')->on('mst_service');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_bom_profile');
    }
}
