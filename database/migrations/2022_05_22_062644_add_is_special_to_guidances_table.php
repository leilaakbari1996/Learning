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
        Schema::table('guidances', function (Blueprint $table) {
            $table->boolean('IsSpecial')->default(false)->after('Slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guidances', function (Blueprint $table) {
            $table->dropColumn('IsSpecial');
        });
    }
};