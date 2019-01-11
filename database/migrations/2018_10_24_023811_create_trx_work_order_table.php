<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxWorkOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_work_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->unsignedInteger('work_request_id')->nullable();
            $table->unsignedInteger('vendor_id');
            $table->unsignedInteger('project_id')->nullable();
            $table->string('description')->nullable();
            $table->integer('status')->default(1);
            $table->bigInteger('total_price')->nullable();
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('work_request_id')->references('id')->on('trx_work_request');
            $table->foreign('vendor_id')->references('id')->on('mst_vendor');
            $table->foreign('project_id')->references('id')->on('pro_project');
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
        Schema::dropIfExists('trx_work_order');
    }
}
