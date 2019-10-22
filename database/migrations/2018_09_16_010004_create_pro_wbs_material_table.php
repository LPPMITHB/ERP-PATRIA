<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProWbsMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_wbs_material', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wbs_id');
            $table->text('part_description')->nullable();
            $table->unsignedInteger('material_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->longText('dimensions_value')->nullable();
            $table->float('weight', 15, 2)->nullable();
            $table->unsignedInteger('bom_prep_id')->nullable();
            $table->string('source')->nullable();
            $table->timestamps();

            $table->foreign('wbs_id')->references('id')->on('pro_wbs');
            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('bom_prep_id')->references('id')->on('mst_bom_prep');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pro_wbs_material');
    }
}
