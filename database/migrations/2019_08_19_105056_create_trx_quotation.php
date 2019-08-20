<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxQuotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_quotation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->unsignedInteger('profile_id');
            $table->unsignedInteger('customer_id')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('price')->default(0);
            $table->float('margin',15,2)->default(0);
            $table->bigInteger('total_price')->default(0);
            $table->string('status')->default(1);
            $table->longText('terms_of_payment')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');  
            $table->timestamps();
            
            $table->foreign('profile_id')->references('id')->on('mst_estimator_profile');
            $table->foreign('customer_id')->references('id')->on('mst_customer');
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
        Schema::dropIfExists('trx_quotation');
    }
}
