<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxPurchaseRequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_purchase_requisition', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->date('required_date')->nullable();
            $table->unsignedInteger('type');
            $table->unsignedInteger('bom_id')->nullable();
            $table->unsignedInteger('purchase_requisition_id')->nullable();
            $table->unsignedInteger('business_unit_id');
            $table->text('description')->nullable();
            $table->text('revision_description')->nullable();
            $table->integer('status')->default(1);
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('approved_by')->nullable();
            $table->timestamps();

            $table->foreign('purchase_requisition_id')->references('id')->on('trx_purchase_requisition');
            $table->foreign('business_unit_id')->references('id')->on('mst_business_unit');
            $table->foreign('bom_id')->references('id')->on('mst_bom');
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
        Schema::dropIfExists('purchase_requisitions');
    }
}
