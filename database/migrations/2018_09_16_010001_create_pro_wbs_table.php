<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProWbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_wbs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description');
            $table->string('deliverables');
            $table->unsignedInteger('project_id')->nullable();
            $table->unsignedInteger('wbs_id')->nullable();
            $table->integer('status')->default(1);
            $table->date('planned_deadline');
            $table->date('actual_deadline')->nullable();
            $table->float('progress')->default(0);
            $table->float('weight')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');  
            $table->integer('process_cost')->nullable();
            $table->integer('other_cost')->nullable();
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('pro_project');
            $table->foreign('wbs_id')->references('id')->on('pro_wbs');
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
        Schema::dropIfExists('pro_wbs');
    }
}
