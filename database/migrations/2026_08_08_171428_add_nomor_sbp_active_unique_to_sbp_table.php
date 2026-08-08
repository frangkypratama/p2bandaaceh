<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kolom bayangan yang berisi nomor_sbp HANYA untuk baris yang masih aktif
        // (deleted_at NULL), NULL untuk baris yang sudah soft-deleted. Unique index
        // di kolom ini mencegah race condition duplikasi nomor SBP di level database,
        // sekaligus tetap mengizinkan nomor yang sama dipakai lagi setelah baris lama
        // di-soft-delete (banyak NULL diperbolehkan oleh unique index).
        Schema::table('sbp', function (Blueprint $table) {
            $table->string('nomor_sbp_active')->nullable()->after('nomor_sbp');
        });

        DB::table('sbp')->whereNull('deleted_at')->update([
            'nomor_sbp_active' => DB::raw('nomor_sbp'),
        ]);

        Schema::table('sbp', function (Blueprint $table) {
            $table->unique('nomor_sbp_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sbp', function (Blueprint $table) {
            $table->dropUnique(['nomor_sbp_active']);
            $table->dropColumn('nomor_sbp_active');
        });
    }
};
