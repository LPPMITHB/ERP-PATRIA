<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxMaterialWriteOffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_material_write_off', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->unsignedInteger('business_unit_id');
            $table->text('description');
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('business_unit_id')->references('id')->on('mst_business_unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_material_write_off');
    }
}
