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
        Schema::table('petugas', function (Blueprint $table) {
            // 1. Tambahkan kolom softDeletes
            $table->softDeletes();

            // 2. Tambahkan composite unique key
            // Pastikan tidak ada NIP duplikat SEBELUM migrasi dijalankan
            // Nama constraint bebas, tapi sebaiknya deskriptif
            $table->unique(['nip', 'deleted_at'], 'petugas_nip_deleted_at_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('petugas', function (Blueprint $table) {
            // Hapus unique key terlebih dahulu
            $table->dropUnique('petugas_nip_deleted_at_unique');
            
            // Hapus kolom softDeletes
            $table->dropSoftDeletes();
        });
    }
};
