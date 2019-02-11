<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstWbsProfile extends Migration
{
    public function up()
    {
        Schema::create('mst_wbs_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->string('deliverables');
            $table->unsignedInteger('wbs_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');  
            $table->timestamps();
            
            $table->foreign('wbs_id')->references('id')->on('mst_wbs_profile');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('branch_id')->references('id')->on('mst_branch');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mst_wbs_profile');
    }
}
