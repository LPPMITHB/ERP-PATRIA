<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstQualityPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_quality_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->text('tables');
            $table->timestamps();

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
        Schema::dropIfExists('mst_quality_plans');
    }
}
