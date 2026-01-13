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
        Schema::create('sbp', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_sbp');
            $table->date('tanggal_sbp');
            $table->string('nomor_surat_perintah');
            $table->date('tanggal_surat_perintah');
            $table->string('nama_pelaku');
            $table->string('jenis_identitas');
            $table->string('nomor_identitas');
            $table->string('lokasi_penindakan');
            $table->time('waktu_penindakan');
            $table->text('alasan_penindakan');
            $table->string('jenis_barang');
            $table->integer('jumlah_barang');
            $table->text('uraian_barang');
            $table->string('nama_petugas_1');
            $table->string('nama_petugas_2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sbp');
    }
};