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
        Schema::create('lhp', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('split_id')->nullable();
            $table->foreign('split_id')->references('id')->on('split')->onDelete('set null');

            $table->string('nomor_lhp');

            // Kolom bayangan, pola yang sama dengan lpf_id_active di tabel split:
            // mencegah satu SPLIT memiliki lebih dari satu LHP aktif, sekaligus tetap
            // mengizinkan split_id yang sama dipakai lagi setelah LHP lama di-soft-delete.
            $table->unsignedBigInteger('split_id_active')->nullable()->unique();

            $table->date('tanggal_lhp');
            $table->string('jenis_pelanggaran');
            $table->text('pelaku_administrasi')->nullable();
            $table->text('saksi_saksi')->nullable();
            $table->text('uraian_barang_tambahan')->nullable();
            $table->text('sarana_pengangkut')->nullable();
            $table->text('dokumen_dokumen')->nullable();
            $table->text('modus_pelanggaran');
            $table->text('pemenuhan_unsur_pasal');
            $table->text('kesimpulan');
            $table->text('alternatif_penyelesaian')->nullable();
            $table->text('informasi_lainnya')->nullable();
            $table->text('catatan_atasan')->nullable();

            $table->unsignedBigInteger('konseptor_id');
            $table->foreign('konseptor_id')->references('id')->on('petugas');

            $table->unsignedBigInteger('pengampu_id');
            $table->foreign('pengampu_id')->references('id')->on('petugas');

            $table->unsignedBigInteger('pemeriksa_id');
            $table->foreign('pemeriksa_id')->references('id')->on('petugas');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lhp');
    }
};
