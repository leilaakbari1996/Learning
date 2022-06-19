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
        Schema::create('guidance_related', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guidance_id');
            $table->unsignedBigInteger('guidance_related_id');
            $table->timestamps();

            $table->foreign('guidance_id')->references('id')->on('guidances')->onDelete('cascade');
            $table->foreign('guidance_related_id')->references('id')->on('guidances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guidance_related');
    }
};
