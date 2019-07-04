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
            $table->text('description');
            $table->double('plan_cost');
            $table->unsignedInteger('cost_type');
            $table->double('actual_cost')->nullable();
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('wbs_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('pro_project');
            $table->foreign('wbs_id')->references('id')->on('pro_wbs');
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
