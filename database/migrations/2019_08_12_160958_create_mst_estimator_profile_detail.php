<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstEstimatorProfileDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_estimator_profile_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('profile_id');
            $table->unsignedInteger('cost_standard_id');
            $table->timestamps();
            
            $table->foreign('profile_id')->references('id')->on('mst_estimator_profile');
            $table->foreign('cost_standard_id')->references('id')->on('mst_estimator_cost_standard');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_estimator_profile_detail');
    }
}
