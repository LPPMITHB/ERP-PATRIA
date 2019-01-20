<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_material', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->longText('name');
            $table->longText('description')->nullable();
            $table->integer('cost_standard_price')->default(0);
            $table->integer('cost_standard_price_service')->default(0);
            $table->integer('latest_price')->default(0);
            $table->integer('average_price')->default(0);
            $table->integer('uom_id')->nullable();
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
            $table->float('weight', 10, 2)->nullable();
            $table->integer('weight_uom_id')->nullable();
            $table->float('height', 7, 2)->nullable();
            $table->integer('height_uom_id')->nullable();
            $table->float('length', 7, 2)->nullable();
            $table->integer('length_uom_id')->nullable();
            $table->float('width', 7, 2)->nullable();
            $table->integer('width_uom_id')->nullable();
            $table->integer('type')->default(1);
            $table->integer('status')->default(1);
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

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
        Schema::dropIfExists('mst_material');
    }
}
