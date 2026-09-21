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
        Schema::create('lpf', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lpp_id')->nullable();
            $table->foreign('lpp_id')->references('id')->on('lpp')->onDelete('set null');

            $table->string('nomor_lpf');

            // Kolom bayangan, pola yang sama dengan lp_id_active di tabel lpp:
            // mencegah satu LPP memiliki lebih dari satu LPF aktif, sekaligus tetap
            // mengizinkan lpp_id yang sama dipakai lagi setelah LPF lama di-soft-delete.
            $table->unsignedBigInteger('lpp_id_active')->nullable()->unique();

            $table->date('tanggal_lpf');
            $table->string('status_penangkapan');
            $table->text('kelengkapan_dokumen');
            $table->text('barang_hasil_penindakan')->nullable();
            $table->text('domain_perkara');
            $table->text('kesimpulan');
            $table->text('usulan');
            $table->text('catatan_disposisi')->nullable();

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
        Schema::dropIfExists('lpf');
    }
};
