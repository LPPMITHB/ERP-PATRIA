<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProProjectWorkResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_project_work_resource', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->unsignedInteger('work_id');
            $table->integer('status')->default(1);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');  
            $table->timestamps();

            $table->foreign('work_id')->references('id')->on('pro_project_work');
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
        Schema::dropIfExists('pro_project_work_resource');
    }
}
