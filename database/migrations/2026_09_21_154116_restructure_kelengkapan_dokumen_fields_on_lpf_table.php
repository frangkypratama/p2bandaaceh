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
            // Poin B. Kelengkapan Dokumen Penindakan pada dokumen asli LPF berupa daftar
            // nomor+tanggal per jenis dokumen, bukan narasi bebas. Nomor/tanggal Surat
            // Perintah/Tugas (poin 1) dan No. LP (poin 3) tidak disimpan di sini karena
            // selalu diambil langsung dari data SBP/LP terkait (read-only pada form).
            $table->string('nomor_surat_limpahan')->nullable()->after('kelengkapan_dokumen');
            $table->date('tanggal_surat_limpahan')->nullable()->after('nomor_surat_limpahan');
            $table->string('nomor_baw_saksi')->nullable()->after('tanggal_surat_limpahan');
            $table->date('tanggal_baw_saksi')->nullable()->after('nomor_baw_saksi');
            $table->string('nomor_bap_tersangka')->nullable()->after('tanggal_baw_saksi');
            $table->date('tanggal_bap_tersangka')->nullable()->after('nomor_bap_tersangka');
            $table->string('nomor_resume_perkara')->nullable()->after('tanggal_bap_tersangka');
            $table->date('tanggal_resume_perkara')->nullable()->after('nomor_resume_perkara');
            $table->string('nomor_dokumen_lain')->nullable()->after('tanggal_resume_perkara');
            $table->date('tanggal_dokumen_lain')->nullable()->after('nomor_dokumen_lain');

            $table->dropColumn('kelengkapan_dokumen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lpf', function (Blueprint $table) {
            $table->text('kelengkapan_dokumen')->nullable();

            $table->dropColumn([
                'nomor_surat_limpahan',
                'tanggal_surat_limpahan',
                'nomor_baw_saksi',
                'tanggal_baw_saksi',
                'nomor_bap_tersangka',
                'tanggal_bap_tersangka',
                'nomor_resume_perkara',
                'tanggal_resume_perkara',
                'nomor_dokumen_lain',
                'tanggal_dokumen_lain',
            ]);
        });
    }
};
