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
        Schema::create('podcasts', function (Blueprint $table) {
            $table->id();
            $table->string('Title');
            $table->longText('Description')->nullable();
            $table->string('Slug');
            $table->string('AudioURl');
            $table->string('ImageURL');
            $table->string('ThumbnailURl');
            $table->boolean('IsSpecial')->default(false);
            $table->boolean('IsNew')->default(false);
            $table->boolean('IsEnable')->default(true);
            $table->integer('Order')->default(1);
            $table->string('SeoTitle')->nullable();
            $table->string('SeoDescription')->nullable();
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
        Schema::dropIfExists('podcasts');
    }
};
