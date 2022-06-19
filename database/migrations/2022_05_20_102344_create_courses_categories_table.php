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
        Schema::create('courses_categories', function (Blueprint $table) {
            $table->id();
            $table->string('Title');
            $table->string('Slug');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedInteger('Order')->default(1);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('courses_categories')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses_categories');
    }
};
