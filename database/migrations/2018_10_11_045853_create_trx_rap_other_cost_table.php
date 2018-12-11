<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxRapOtherCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_rap_other_cost', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->bigInteger('cost');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('work_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('pro_project');
            $table->foreign('work_id')->references('id')->on('pro_project_work');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('branch_id')->references('id')->on('mst_branch'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_rap_other_and_process_cost');
    }
}
