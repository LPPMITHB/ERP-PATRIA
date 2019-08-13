<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstEstimateCostStandard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_estimate_cost_standard', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->text('name');
            $table->text('description');
            $table->unsignedInteger('uom_id');
            $table->unsignedInteger('estimate_wbs_id');
            $table->integer('value')->default(0);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');  
            $table->timestamps();
            
            $table->foreign('estimate_wbs_id')->references('id')->on('mst_estimate_wbs');
            $table->foreign('uom_id')->references('id')->on('mst_uom');
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
        Schema::dropIfExists('mst_estimate_cost_standard');
    }
}
