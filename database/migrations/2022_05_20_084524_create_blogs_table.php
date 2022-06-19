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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('Title');
            $table->longText('Text');
            $table->string('ImageURL');
            $table->string('ThumbnailURl');
            $table->integer('Views')->default(0);
            $table->integer('Save')->default(0);
            $table->integer('Like')->default(0);
            $table->string('Slug');
            $table->boolean('IsEnable')->default(true);
            $table->string('SeoTitle')->nullable();
            $table->string('SeoDescription')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->timestamps();
            $table->foreign('author_id')->references('id')->on('users')
                ->onDelete('set Null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
};
