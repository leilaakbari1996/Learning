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
        Schema::create('course_order', function (Blueprint $table) {
            $table->id();
            $table->integer('Price');
            $table->string('Discount');
            $table->unsignedInteger('Count')->default(1);
            $table->unsignedBigInteger('orderable_id');
            $table->string('orderable_type');
            $table->unsignedBigInteger('order_id');
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_order');
    }
};
