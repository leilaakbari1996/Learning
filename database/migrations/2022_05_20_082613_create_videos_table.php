<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('Title');
            $table->string('VideoURL');
            $table->integer('Time')->nullable();
            $table->unsignedInteger('Price')->default(0);
            $table->boolean('IsFree')->default(false);
            $table->unsignedBigInteger('video_title_id');
            $table->timestamps();
            $table->foreign('video_title_id')->references('id')->on('videos_titles')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
};
