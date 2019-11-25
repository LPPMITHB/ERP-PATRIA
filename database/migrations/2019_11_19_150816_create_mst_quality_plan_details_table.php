<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstQualityPlanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_quality_plan_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quality_plan_id');
            $table->unsignedInteger('quality_type_id');
            $table->unsignedInteger('quality_plan_role');
            $table->unsignedInteger('quality_plan_role_action');
            $table->timestamps();

            $table->foreign('quality_plan_id')->references('id')->on('mst_quality_plans');
            $table->foreign('quality_type_id')->references('id')->on('mst_quality_control_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quality_plan_details');
    }
}
