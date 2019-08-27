<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxYardPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_yard_plan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('yard_id');
            $table->date('planned_start_date');
            $table->date('planned_end_date');
            $table->integer('planned_duration');
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->integer('actual_duration')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('wbs_id')->nullable();
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('yard_id')->references('id')->on('mst_yard');
            $table->foreign('project_id')->references('id')->on('pro_project');
            $table->foreign('wbs_id')->references('id')->on('pro_wbs');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_yard_plan');
    }
}
