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
        Schema::table('pencacahan', function (Blueprint $table) {
            $table->string('no_surat_tugas_pencacahan')->nullable()->after('tanggal_ba_cacah');
            $table->date('tanggal_surat_tugas_pencacahan')->nullable()->after('no_surat_tugas_pencacahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pencacahan', function (Blueprint $table) {
            $table->dropColumn(['no_surat_tugas_pencacahan', 'tanggal_surat_tugas_pencacahan']);
        });
    }
};
