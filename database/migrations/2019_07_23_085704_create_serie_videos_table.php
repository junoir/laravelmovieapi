<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSerieVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serie_videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('episode_id')->unsigned();
            $table->string('server');
            $table->string('link');
            $table->string('lang')->nullable();
            $table->boolean('hd')->default(0);
            $table->boolean('status')->default(1);
            $table->foreign('episode_id')->references('id')->on('episodes')->onDelete('cascade');
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
        Schema::dropIfExists('serie_videos');
    }
}
