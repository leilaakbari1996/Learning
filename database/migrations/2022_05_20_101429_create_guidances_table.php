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
        Schema::create('guidances', function (Blueprint $table) {
            $table->id();
            $table->string('Title');
            $table->longText('Description');
            $table->integer('Order')->default(1);
            $table->string('Slug');
            $table->string('IconURL')->nullable();
            $table->string('ImageURL')->nullable();
            $table->string('VideoURL')->nullable();
            $table->boolean('IsEnable')->default(true);
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
        Schema::dropIfExists('guidances');
    }
};
