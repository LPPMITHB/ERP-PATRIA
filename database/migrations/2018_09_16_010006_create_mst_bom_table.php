<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstBomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_bom', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->longText('description');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('wbs_id')->nullable();
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('mst_bom');
    }
}
