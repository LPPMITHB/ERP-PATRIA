<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstQualityTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_quality_control_type', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ship_id')->nullable(); //quality Plan
            $table->unsignedInteger('peran')->nullable();//peran config
            $table->string('name');
            $table->text('description')->nullable();

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('branch_id')->references('id')->on('mst_branch');
            $table->foreign('ship_id')->references('id')->on('mst_ship');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_quality_types');
    }
}
