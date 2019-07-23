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
            $table->integer('old_quantity');
            $table->integer('new_quantity');
            $table->integer('old_reference_document_detail');
            $table->integer('new_reference_document_detail');
            $table->timestamps();

            $table->foreign('reverse_transaction_id')->references('id')->on('trx_reverse_transaction');
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
