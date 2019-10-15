<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstBomPrepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_bom_prep', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('material_id')->nullable();
            $table->unsignedInteger('project_id')->nullable();
            $table->float('weight',15,2)->nullable();
            $table->float('quantity',15,2)->nullable();
            $table->integer('status')->default(1);
            $table->string('source')->default('Stock');
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('project_id')->references('id')->on('pro_project');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_bom_prep');
    }
}
