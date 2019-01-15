<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('trx_resource', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('resource_id')->nullable();  
            $table->unsignedInteger('project_id')->nullable();           
            $table->unsignedInteger('wbs_id')->nullable();       
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->foreign('resource_id')->references('id')->on('mst_resource');
            $table->foreign('project_id')->references('id')->on('pro_project');          
            $table->foreign('wbs_id')->references('id')->on('pro_wbs');          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_resource');
    }
}
