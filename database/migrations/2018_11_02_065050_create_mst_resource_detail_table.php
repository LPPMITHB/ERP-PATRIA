<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstResourceDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_resource_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('resource_id')->nullable();           
            $table->unsignedInteger('project_id')->nullable();           
            $table->unsignedInteger('wbs_id')->nullable();       
            $table->unsignedInteger('category_id');       
            $table->integer('quantity')->nullable();
            $table->timestamps();

            $table->foreign('resource_id')->references('id')->on('mst_resource');
            $table->foreign('project_id')->references('id')->on('pro_project');          
            $table->foreign('wbs_id')->references('id')->on('pro_wbs');
            $table->foreign('category_id')->references('id')->on('mst_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_resource_detail');
    }
}
