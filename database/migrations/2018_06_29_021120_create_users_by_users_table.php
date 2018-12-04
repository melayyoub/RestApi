<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersByUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users_by_users');
        Schema::create('users_by_users', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('api_id', 128)->unique()->nullable();
            $table->integer('uid')->nullable();
            $table->integer('blocked')->default(0);
            $table->integer('user')->unique();
            $table->text('firstname')->nullable();
            $table->text('lastname')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_by_users');
    }
}
