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
            $table->string('nomor_ba_riksa')->nullable()->after('nomor_sbp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sbp', function (Blueprint $table) {
            $table->dropColumn('nomor_ba_riksa');
        });
    }
};
