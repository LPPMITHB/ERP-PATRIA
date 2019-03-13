<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstServiceDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_service_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('service_id');  
            $table->string('name');
            $table->unsignedInteger('uom_id');
            $table->string('description')->nullable();
            $table->biginteger('cost_standard_price')->default(0);

            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('mst_service');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_service_detail_');
    }
}
