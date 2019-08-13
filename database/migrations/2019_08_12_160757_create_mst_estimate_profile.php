<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstEstimateProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_estimate_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->text('description');
            $table->unsignedInteger('ship_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');  
            $table->timestamps();
            
            $table->foreign('ship_id')->references('id')->on('mst_ship');
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
        Schema::dropIfExists('mst_estimate_profile');
    }
}
