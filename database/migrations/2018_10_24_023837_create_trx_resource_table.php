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
            $table->unsignedInteger('resource_detail_id')->nullable();
            $table->integer('category_id')->nullable(); 
            $table->unsignedInteger('project_id')->nullable();           
            $table->unsignedInteger('wbs_id')->nullable();       
            $table->integer('quantity')->default(1);
            $table->text('description')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');  
            $table->timestamps();

            $table->foreign('resource_id')->references('id')->on('mst_resource');
            $table->foreign('resource_detail_id')->references('id')->on('mst_resource_detail');
            $table->foreign('project_id')->references('id')->on('pro_project');          
            $table->foreign('wbs_id')->references('id')->on('pro_wbs');    
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
        Schema::dropIfExists('trx_resource');
    }
}
