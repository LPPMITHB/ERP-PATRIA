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
            $table->string('brand')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('description')->nullable();
            // $table->integer('category_id');
            $table->string('machine_type')->nullable();
            $table->integer('cost_standard_price');
            $table->date('manufactured_date')->nullable();
            $table->date('purchasing_date')->nullable();
            $table->unsignedInteger('purchasing_price')->nullable();
            $table->unsignedInteger('lifetime')->nullable();
            $table->unsignedInteger('depreciation_method')->nullable();
            $table->float('accumulated_depreciation')->nullable();
            $table->date('running_hours')->nullable();
            $table->unsignedInteger('cost/hour')->nullable();
            $table->unsignedInteger('utilization');
            $table->unsignedInteger('performance')->nullable();
            $table->unsignedInteger('productivity');
            $table->unsignedInteger('status')->default(1);
            $table->unsignedInteger('vendor_id')->nullable();            
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('mst_branch'); 
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('vendor_id')->references('id')->on('mst_vendor');
            // $table->foreign('category_id')->references('id')->on('mst_configuration');

            // $table->foreign('uom_id')->references('id')->on('mst_uom');
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
