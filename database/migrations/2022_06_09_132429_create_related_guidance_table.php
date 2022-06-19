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
        Schema::create('related_guidance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guidance_id');
            $table->unsignedBigInteger('relatedable_id');
            $table->string('relatedable_type');
            $table->timestamps();

            $table->foreign('guidance_id')->references('id')->on('guidances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('related_guidance');
    }
};
