<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstMaterialStandardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_material_standard', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_standard_id');
            $table->unsignedInteger('wbs_standard_id')->nullable();
            $table->unsignedInteger('material_id')->nullable();
            $table->float('quantity',15,2);
            $table->string('source')->default('Stock');
            $table->timestamps();
            
            $table->foreign('project_standard_id')->references('id')->on('mst_project_standard');
            $table->foreign('wbs_standard_id')->references('id')->on('mst_wbs_standard');
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
