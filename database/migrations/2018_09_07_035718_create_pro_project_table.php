<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('pro_project', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->string('drawing')->nullable();
            $table->unsignedInteger('business_unit_id');
            $table->unsignedInteger('project_sequence');
            $table->unsignedInteger('ship_id');
            $table->unsignedInteger('customer_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedInteger('sales_order_id')->nullable();
            $table->date('planned_start_date');
            $table->date('planned_end_date');
            $table->string('planned_duration')->nullable();
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->string('actual_duration')->nullable();
            $table->float('progress');
            $table->string('flag')->nullable();
            $table->string('class_name')->nullable();
            $table->string('class_contact_person_name')->nullable();
            $table->string('class_contact_person_phone')->nullable();
            $table->string('class_contact_person_email')->nullable();
            $table->integer('status')->default(1);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');            
            $table->timestamps();

            $table->foreign('business_unit_id')->references('id')->on('mst_business_unit');
            $table->foreign('branch_id')->references('id')->on('mst_branch');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('ship_id')->references('id')->on('mst_ship');
            $table->foreign('customer_id')->references('id')->on('mst_customer');
            // $table->foreign('sales_order_id')->references('id')->on('trx_sales_order');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pro_project');
    }
}
