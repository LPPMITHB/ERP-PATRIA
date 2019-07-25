<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxReverseTransactionDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_reverse_transaction_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('reverse_transaction_id');
            $table->unsignedInteger('material_id');
            $table->float('old_quantity');
            $table->float('new_quantity')->nullable();
            $table->integer('old_reference_document_detail');
            $table->integer('new_reference_document_detail')->nullable();
            $table->timestamps();

            $table->foreign('reverse_transaction_id')->references('id')->on('trx_reverse_transaction');
            $table->foreign('material_id')->references('id')->on('mst_material');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_reverse_transaction_detail');
    }
}
