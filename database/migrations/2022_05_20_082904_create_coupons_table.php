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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->integer('Count')->default(1);
            $table->enum('Type',["Bill","Code"])->default('Code');
            $table->integer('Amount');
            $table->integer('MinOrder')->nullable()->default(0);
            $table->timestamp('StartDate')->nullable();
            $table->timestamp('EndDate')->nullable();
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
        Schema::dropIfExists('coupons');
    }
};
