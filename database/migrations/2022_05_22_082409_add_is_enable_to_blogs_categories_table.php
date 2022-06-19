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
        Schema::table('blogs_categories', function (Blueprint $table) {
            $table->boolean('IsEnable')->default(true)
                ->after('IsSpecial');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs_categories', function (Blueprint $table) {
            $table->dropColumn('IsEnable');
        });
    }
};
