<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxReverseTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_reverse_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->integer('type');
            $table->integer('old_reference_document');
            $table->integer('new_reference_document')->nullable();
            $table->unsignedInteger('business_unit_id');
            $table->text('description')->nullable();
            $table->text('revision_description')->nullable();
            $table->integer('status')->default(1);
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('approved_by')->nullable();
            $table->date('approval_date')->nullable();
            $table->timestamps();

            $table->foreign('business_unit_id')->references('id')->on('mst_business_unit');
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
        Schema::dropIfExists('trx_reverse_transaction');
    }
}
