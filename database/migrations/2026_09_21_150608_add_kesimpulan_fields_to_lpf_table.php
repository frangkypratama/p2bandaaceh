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
        Schema::table('lpf', function (Blueprint $table) {
            // Poin D. Kesimpulan pada dokumen asli LPF berupa daftar pertanyaan
            // tetap dengan jawaban terbatas, bukan narasi bebas. Kolom "kesimpulan"
            // (text) tetap dipertahankan sebagai ringkasan otomatis untuk kompatibilitas
            // tampilan lama (mis. cetak gabungan berkas penyidikan).
            $table->string('lengkap_berkas')->nullable()->after('kelengkapan_dokumen');
            $table->string('cukup_barang_bukti')->nullable()->after('lengkap_berkas');
            $table->string('cukup_alat_bukti')->nullable()->after('cukup_barang_bukti');
            $table->string('keberadaan_pelaku')->nullable()->after('cukup_alat_bukti');
            $table->string('keterkaitan_bukti_pelaku')->nullable()->after('keberadaan_pelaku');
            $table->string('indikasi_pelanggaran')->nullable()->after('keterkaitan_bukti_pelaku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lpf', function (Blueprint $table) {
            $table->dropColumn([
                'lengkap_berkas',
                'cukup_barang_bukti',
                'cukup_alat_bukti',
                'keberadaan_pelaku',
                'keterkaitan_bukti_pelaku',
                'indikasi_pelanggaran',
            ]);
        });
    }
};
