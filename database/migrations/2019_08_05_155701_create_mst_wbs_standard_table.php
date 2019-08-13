<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstWbsStandardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_wbs_standard', function (Blueprint $table) {
            $table->increments('id');
            $table->text('number');
            $table->text('description');
            $table->string('deliverables');
            $table->unsignedInteger('project_standard_id')->nullable();
            $table->unsignedInteger('wbs_standard_id')->nullable();
            $table->integer('planned_duration');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');  
            $table->timestamps();
            
            $table->foreign('project_standard_id')->references('id')->on('mst_project_standard');
            $table->foreign('wbs_standard_id')->references('id')->on('mst_wbs_standard');
            $table->foreign('branch_id')->references('id')->on('mst_branch');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_wbs_standard');
    }
}
