<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstResourceProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_resource_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('resource_id')->nullable();
            $table->unsignedInteger('resource_detail_id')->nullable();
            $table->string('category_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('resource_id')->references('id')->on('mst_resource');
            $table->foreign('resource_detail_id')->references('id')->on('mst_resource_detail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_resource_profile');
    }
}
