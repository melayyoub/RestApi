<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->nullable();
            $table->text('path')->nullable();
            $table->text('url');
            $table->text('title');
            $table->text('body');
            $table->text('image')->default('img/siteImage.png');
            $table->text('video')->default('img/siteVideo.png');
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
        Schema::dropIfExists('sites');
    }
}
