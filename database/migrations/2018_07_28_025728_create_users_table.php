<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->unsignedInteger('type');
            $table->unsignedInteger('role_id')->nullable();
            $table->unsignedInteger('branch_id')->nullable();
            $table->integer('status')->default(1);
            $table->text('business_unit_id');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
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
        Schema::dropIfExists('users');
    }
}
