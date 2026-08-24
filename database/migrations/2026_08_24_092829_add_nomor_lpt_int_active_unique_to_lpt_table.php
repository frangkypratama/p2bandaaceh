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
        // Kolom bayangan yang berisi nomor_lpt_int HANYA untuk baris yang masih aktif
        // (deleted_at NULL), NULL untuk baris yang sudah soft-deleted. Unique index
        // di kolom ini mencegah race condition duplikasi nomor LPT di level database,
        // sekaligus tetap mengizinkan nomor yang sama dipakai lagi setelah baris lama
        // di-soft-delete (banyak NULL diperbolehkan oleh unique index). Pola yang sama
        // dengan nomor_sbp_active di migration add_nomor_sbp_active_unique_to_sbp_table.
        Schema::table('lpt', function (Blueprint $table) {
            $table->unsignedInteger('nomor_lpt_int_active')->nullable()->after('nomor_lpt_int');
        });

        DB::table('lpt')->whereNull('deleted_at')->update([
            'nomor_lpt_int_active' => DB::raw('nomor_lpt_int'),
        ]);

        Schema::table('lpt', function (Blueprint $table) {
            $table->unique('nomor_lpt_int_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lpt', function (Blueprint $table) {
            $table->dropUnique(['nomor_lpt_int_active']);
            $table->dropColumn('nomor_lpt_int_active');
        });
    }
};
