<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstBomStandardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_bom_standard', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->text('description');
            $table->unsignedInteger('project_standard_id');
            $table->unsignedInteger('wbs_standard_id')->nullable();
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('project_standard_id')->references('id')->on('mst_project_standard');
            $table->foreign('wbs_standard_id')->references('id')->on('mst_wbs_standard');
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
        Schema::dropIfExists('mst_bom_standard');
    }
}
