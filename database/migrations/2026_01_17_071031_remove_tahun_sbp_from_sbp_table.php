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
            // Drop the index first
            $table->dropIndex(['nomor_sbp_int', 'tahun_sbp']); // Laravel will infer the index name
            // Then drop the column
            $table->dropColumn('tahun_sbp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sbp', function (Blueprint $table) {
            $table->integer('tahun_sbp')->after('nomor_sbp_int')->nullable();
            $table->index(['nomor_sbp_int', 'tahun_sbp']);
        });
    }
};
