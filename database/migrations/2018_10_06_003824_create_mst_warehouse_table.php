<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstWarehouseTable extends Migration
{
    /**
 * Run the migrations.
 *
 * @return void
 */
    public function up()
{
    Schema::create('mst_warehouse', function (Blueprint $table) {
        $table->increments('id');
        $table->string('code')->unique();
        $table->string('name');
        $table->text('description')->nullable();
        $table->integer('pic')->nullable();
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
        Schema::dropIfExists('mst_warehouse');
}

}
