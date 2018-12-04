<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rest_apis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->nullable();
            $table->text('request')->nullable();
            $table->text('url')->nullable();
            $table->text('result')->nullable();
            $table->text('alert')->nullable();
            $table->text('table')->nullable();
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
        Schema::dropIfExists('rest_apis');
    }
}
