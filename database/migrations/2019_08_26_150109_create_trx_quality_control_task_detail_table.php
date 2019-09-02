<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxQualityControlTaskDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_quality_control_task_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('qctask_id');
            $table->integer('position');
            $table->text('description')->nullable();
            
            $table->timestamps();

            $table->foreign('qctask_id')->references('id')->on('trx_quality_control_task');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_quality_control_task_detail');
    }
}
