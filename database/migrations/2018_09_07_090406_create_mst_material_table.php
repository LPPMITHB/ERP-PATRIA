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
            $table->string('name');
            $table->longText('description')->nullable();
            $table->integer('cost_standard_price');
            $table->float('weight', 10, 2)->nullable();
            $table->float('height', 7, 2)->nullable();
            $table->float('length', 7, 2)->nullable();
            $table->float('width', 7, 2)->nullable();
            $table->float('volume', 12, 2)->nullable();
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
