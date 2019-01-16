<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstResourceDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_resource_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('resource_id');  
            $table->string('code')->unique();
            $table->string('brand')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('description')->nullable();
            $table->string('category_id');
            $table->date('manufactured_date')->nullable();
            $table->date('purchasing_date')->nullable();
            $table->unsignedInteger('purchasing_price')->nullable();
            $table->unsignedInteger('lifetime')->nullable();
            $table->unsignedInteger('depreciation_method')->nullable();
            $table->float('accumulated_depreciation')->nullable();
            $table->integer('running_hours')->nullable()->default(0);
            $table->unsignedInteger('cost_per_hour')->nullable();
            $table->float('utilization')->default(0);
            $table->unsignedInteger('performance')->nullable();
            $table->unsignedInteger('performance_uom_id')->nullable(); 
            $table->unsignedInteger('time')->nullable();
            $table->unsignedInteger('time_uom_id')->nullable(); 
            $table->float('productivity')->default(0);
            $table->unsignedInteger('status')->default(0);
            $table->unsignedInteger('vendor_id')->nullable(); 
            $table->string('others_name')->nullable();
            $table->string('sub_con_address')->nullable();
            $table->string('sub_con_phone')->nullable();
            $table->string('sub_con_competency')->nullable();
            $table->timestamps();

            $table->foreign('resource_id')->references('id')->on('mst_resource');
            $table->foreign('vendor_id')->references('id')->on('mst_vendor');
            $table->foreign('performance_uom_id')->references('id')->on('mst_uom');
            $table->foreign('time_uom_id')->references('id')->on('mst_uom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_resource_detail');
    }
}
