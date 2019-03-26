<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxPurchaseOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_purchase_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->unsignedInteger('purchase_requisition_id')->nullable();
            $table->unsignedInteger('vendor_id');
            $table->string('currency');
            $table->unsignedInteger('value');
            $table->text('description')->nullable();
            $table->text('revision_description')->nullable();
            $table->integer('status')->default(1);
            $table->float('tax')->default(0);
            $table->float('estimated_freight',15,2)->default(0);
            $table->string('delivery_terms')->nullable();
            $table->string('payment_terms')->nullable();
            $table->double('total_price')->nullable();
            $table->date('delivery_date')->nullable();
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('approved_by')->nullable();
            $table->timestamps();

            $table->foreign('purchase_requisition_id')->references('id')->on('trx_purchase_requisition');
            $table->foreign('vendor_id')->references('id')->on('mst_vendor');
            $table->foreign('branch_id')->references('id')->on('mst_branch');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_purchase_order');
    }
}
