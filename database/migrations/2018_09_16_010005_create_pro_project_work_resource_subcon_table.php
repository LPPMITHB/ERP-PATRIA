<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProProjectWorkResourceSubconTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_project_work_resource_subcan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->unsignedInteger('subcon_id');
            $table->unsignedInteger('resource_id');
            $table->unsignedInteger('activity_id');
            $table->float('tonase');
            $table->integer('status')->default(1);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id'); 
            $table->timestamps();

            // $table->foreign('subcon_id')->references('id')->on('mst_subcon');
            $table->foreign('resource_id')->references('id')->on('pro_project_work_resource');
            $table->foreign('activity_id')->references('id')->on('pro_project_work_activity');
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
        Schema::dropIfExists('pro_project_work_resource_subcan');
    }
}
