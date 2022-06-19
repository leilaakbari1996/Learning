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
        Schema::table('videos_titles', function (Blueprint $table) {
            $table->boolean('IsEnable')->default(true)->after('Order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos_titles', function (Blueprint $table) {
            $table->dropColumn('IsEnable');
        });
    }
};
