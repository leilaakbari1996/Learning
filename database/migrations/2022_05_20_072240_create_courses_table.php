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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('Title');
            $table->longText('Description')->nullable();
            $table->longText('AfterBuyDescription')->nullable();
            $table->string('Slug')->unique();
            $table->unsignedInteger('Price');
            $table->unsignedInteger('Discount')->default(0);
            $table->json('Images')->nullable();
            $table->json('Videos')->nullable();
            $table->string('PreviewImageURL');
            $table->enum('Type',['Online','Offline'])->default('Offline');
            $table->unsignedInteger('Order')->default(1);
            $table->unsignedInteger('Views')->default(0);
            $table->unsignedInteger('Likes')->default(0);
            $table->unsignedInteger('TotalTime')->nullable();
            $table->unsignedInteger('NumberOfBuys')->default(0);
            $table->boolean('IsFree')->default(false);
            $table->boolean('IsSpecial')->default(false);
            $table->boolean('IsNew')->default(false);
            $table->boolean('IsEnable')->default(true);
            $table->enum('Level',['Beginner','Intermediate','Advance','BegToAdvance'])->default('BegToAdvance');
            $table->enum('Status',['End','Beginning','During'])->default('End');
            $table->timestamp('UpdateDate')->nullable();
            $table->json('FAQ')->nullable();
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
        Schema::dropIfExists('courses');
    }
};
