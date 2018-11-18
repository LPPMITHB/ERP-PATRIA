<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_resource', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->unsignedInteger('category_id')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('used')->default(0);
            $table->integer('usage')->default(0);
            $table->string('description')->nullable();
            $table->unsignedInteger('uom_id');
            $table->integer('status')->default(1);
            $table->integer('type');
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('mst_branch'); 
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('uom_id')->references('id')->on('mst_uom');
            $table->foreign('category_id')->references('id')->on('mst_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_resource');
    }
}
