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
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('api_id', 128)->unique()->nullable();
            $table->integer('blocked')->default(0);
            $table->string('email')->unique();
            $table->text('password');
            $table->text('firstname')->nullable();
            $table->text('lastname')->nullable();
            $table->text('industry')->nullable();
            $table->text('ip')->nullable();
            $table->text('job_title')->nullable();
            $table->integer('api_only')->default(0);
            $table->integer('role')->default(1);
            $table->integer('level')->default(1);
            $table->integer('profile')->nullable()->unique();
            $table->string('api_token', 128)->unique()->nullable();
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
        Schema::dropIfExists('users');
    }
}
