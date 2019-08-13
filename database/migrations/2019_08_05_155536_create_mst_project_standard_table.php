<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstProjectStandardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_project_standard', function (Blueprint $table) {
            $table->increments('id');
            $table->string('drawing')->nullable();
            $table->unsignedInteger('business_unit_id');
            $table->unsignedInteger('ship_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('planned_duration')->nullable();
            $table->unsignedInteger('project_type');
            $table->integer('status')->default(1);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');            
            $table->timestamps();

            $table->foreign('business_unit_id')->references('id')->on('mst_business_unit');
            $table->foreign('branch_id')->references('id')->on('mst_branch');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('ship_id')->references('id')->on('mst_ship');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_project_standard');
    }
}
