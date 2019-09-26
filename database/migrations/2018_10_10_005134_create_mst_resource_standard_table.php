<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstResourceStandardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_resource_standard', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_standard_id');
            $table->unsignedInteger('wbs_standard_id')->nullable();
            $table->unsignedInteger('resource_id')->nullable();
            $table->integer('quantity')->default(1);
            $table->timestamps();
            
            $table->foreign('project_standard_id')->references('id')->on('mst_project_standard');
            $table->foreign('wbs_standard_id')->references('id')->on('mst_wbs_standard');
            $table->foreign('resource_id')->references('id')->on('mst_resource');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_resource_standard');
    }
}
