<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_stock', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('material_id')->unique();
            $table->integer('quantity');
            $table->integer('reserved')->default(0);
            $table->unsignedInteger('branch_id');
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('mst_branch'); 
            $table->foreign('material_id')->references('id')->on('mst_material');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
