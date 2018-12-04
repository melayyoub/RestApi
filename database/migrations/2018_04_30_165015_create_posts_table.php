<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->nullable();
            $table->text('path')->nullable();
            $table->text('title');
            $table->text('body');
            $table->text('image')->default('img/blogImage.png');
            $table->text('video')->default('img/blogVideo.png');
            $table->text('tags')->nullable();
            $table->integer('homepage')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
