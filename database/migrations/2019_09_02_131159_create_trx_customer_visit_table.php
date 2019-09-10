<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxCustomerVisitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_customer_visit', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('business_unit_id')->nullable();
            $table->date('planned_date')->nullable();
            $table->string('type');
            $table->unsignedInteger('customer_id');
            $table->text('note')->nullable();
            $table->text('report')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');
            $table->timestamps();

            $table->foreign('business_unit_id')->references('id')->on('mst_business_unit');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('branch_id')->references('id')->on('mst_branch');
            $table->foreign('customer_id')->references('id')->on('mst_customer');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_customer_visit');
    }
}
