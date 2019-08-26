<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->unsignedInteger('sales_order_id');
            $table->unsignedInteger('project_id');
            $table->float('current_project_progress',15,2);
            $table->float('top_project_progress',15,2);
            $table->float('top_payment_percentage',15,2);
            $table->integer('payment_value');
            $table->integer('top_index');
            $table->string('status')->default(1);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');  
            $table->timestamps();

            $table->foreign('sales_order_id')->references('id')->on('trx_sales_order');
            $table->foreign('project_id')->references('id')->on('pro_project');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('branch_id')->references('id')->on('mst_branch');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_invoice');
    }
}
