<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxQualityControlTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_quality_control_task', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->unsignedInteger('wbs_id');
            $table->text('description')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');  
            $table->timestamps();

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
        Schema::dropIfExists('trx_quality_control_task');
    }
}
