<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxGoodsMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_goods_movement', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->string('description')->nullable();
            $table->unsignedInteger('storage_location_from_id');
            $table->unsignedInteger('storage_location_to_id');
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('mst_branch');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('storage_location_from_id')->references('id')->on('mst_storage_location');
            $table->foreign('storage_location_to_id')->references('id')->on('mst_storage_location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_goods_movement');
    }
}
