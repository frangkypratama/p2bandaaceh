<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sbp', function (Blueprint $table) {
            $table->string('nomor_ba_tegah')->nullable()->after('nomor_ba_riksa');
            $table->string('nomor_ba_segel')->nullable()->after('nomor_ba_tegah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sbp', function (Blueprint $table) {
            $table->dropColumn(['nomor_ba_tegah', 'nomor_ba_segel']);
        });
    }
};
