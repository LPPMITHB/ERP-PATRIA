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
            $table->string('serial_number')->nullable();
            $table->string('brand')->nullable();
            $table->integer('quantity')->default(1);
            $table->text('description')->nullable();
            $table->integer('category_id');
            $table->double('kva')->nullable();
            $table->double('amp')->nullable();
            $table->double('volt')->nullable();
            $table->integer('phase')->nullable();
            $table->double('length')->nullable();
            $table->double('width')->nullable();
            $table->double('height')->nullable();
            $table->string('manufactured_in')->nullable();
            $table->string('manufactured_date')->nullable();
            $table->string('purchasing_date')->nullable();
            $table->double('purchasing_price')->nullable();
            $table->double('lifetime')->nullable();
            $table->unsignedInteger('lifetime_uom_id')->nullable(); 
            $table->unsignedInteger('depreciation_method')->default(0);
            $table->float('accumulated_depreciation')->nullable();
            $table->integer('running_hours')->nullable()->default(0);
            $table->double('cost_per_hour')->nullable();
            $table->float('utilization')->default(0);
            $table->double('performance')->nullable();
            $table->unsignedInteger('performance_uom_id')->nullable(); 
            $table->float('productivity')->default(0);
            $table->unsignedInteger('status')->default(1);
            $table->unsignedInteger('vendor_id')->nullable(); 
            $table->string('others_name')->nullable();
            $table->string('sub_con_address')->nullable();
            $table->string('sub_con_phone')->nullable();
            $table->string('sub_con_competency')->nullable();
            $table->unsignedInteger('po_id')->nullable(); 
            $table->timestamps();

            $table->foreign('resource_id')->references('id')->on('mst_resource');
            $table->foreign('vendor_id')->references('id')->on('mst_vendor');
            $table->foreign('performance_uom_id')->references('id')->on('mst_uom');
            $table->foreign('lifetime_uom_id')->references('id')->on('mst_uom');
            $table->foreign('po_id')->references('id')->on('trx_purchase_order');
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
