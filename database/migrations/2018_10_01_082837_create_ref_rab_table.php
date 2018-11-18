<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefRabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_rab', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->unsignedInteger('project_id');
            $table->bigInteger('total_price')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('pro_project');
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
        Schema::dropIfExists('ref_rab');
    }
}
