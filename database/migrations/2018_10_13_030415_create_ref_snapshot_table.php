<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefSnapshotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_snapshot', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('status')->default(1); 
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('branch_id');
            $table->text('revision_description')->nullable();
            $table->unsignedInteger('audited_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('approved_by')->nullable();
            $table->date('approval_date')->nullable();
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('mst_branch');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('audited_by')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_snapshot');
    }
}
