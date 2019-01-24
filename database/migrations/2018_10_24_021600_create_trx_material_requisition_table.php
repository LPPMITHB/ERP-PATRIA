<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxMaterialRequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_material_requisition', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->unsignedInteger('project_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(1);
            $table->integer('type');
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('pro_project');
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
        Schema::dropIfExists('trx_material_requisition');
    }
}
