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
        Schema::create('lpp', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lp_id')->nullable();
            $table->foreign('lp_id')->references('id')->on('lp')->onDelete('set null');

            $table->string('nomor_lpp');

            // Kolom bayangan, pola yang sama dengan lphp_id_active di tabel lp:
            // mencegah satu LP memiliki lebih dari satu LPP aktif, sekaligus tetap
            // mengizinkan lp_id yang sama dipakai lagi setelah LPP lama di-soft-delete.
            $table->unsignedBigInteger('lp_id_active')->nullable()->unique();

            $table->date('tanggal_lpp');
            $table->string('asal_perkara');
            $table->string('jenis_penindakan');
            $table->string('status_pelanggaran');
            $table->text('uraian_pelanggaran');
            $table->text('dokumen_barang')->nullable();
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
        Schema::dropIfExists('lpp');
    }
};
