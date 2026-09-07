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
        Schema::create('lphp', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sbp_id')->nullable();
            $table->foreign('sbp_id')->references('id')->on('sbp')->onDelete('set null');

            $table->string('nomor_lphp');

            // Kolom bayangan: hanya berisi sbp_id untuk baris LPHP yang masih aktif
            // (deleted_at NULL), NULL untuk baris yang sudah soft-deleted. Unique index
            // mencegah satu SBP memiliki lebih dari satu LPHP aktif, sekaligus tetap
            // mengizinkan sbp_id yang sama dipakai lagi setelah LPHP lama di-soft-delete.
            // Pola yang sama dengan nomor_sbp_active di tabel sbp.
            $table->unsignedBigInteger('sbp_id_active')->nullable()->unique();

            $table->date('tanggal_lphp');
            $table->string('dugaan_pelanggaran');
            $table->string('nama_tempat')->nullable();
            $table->string('pasal');
            $table->text('uu_terkait');

            $table->unsignedBigInteger('konseptor_id');
            $table->foreign('konseptor_id')->references('id')->on('petugas');

            $table->unsignedBigInteger('pengampu_id');
            $table->foreign('pengampu_id')->references('id')->on('petugas');

            $table->unsignedBigInteger('pemeriksa_id');
            $table->foreign('pemeriksa_id')->references('id')->on('petugas');

            $table->text('catatan')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lphp');
    }
};
