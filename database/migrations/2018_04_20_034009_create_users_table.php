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
            $table->timestamps();

            $table->string('fname');
            $table->string('lname');
            $table->string('email')->unique();
            $table->string('password');

            $table->tinyInteger('is_student')->default(0);
            $table->tinyInteger('is_supervisor')->default(0);
            $table->tinyInteger('is_coordinator')->default(0);

            $table->rememberToken();


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
