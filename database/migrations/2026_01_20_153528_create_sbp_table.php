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
            $table->string('nomor_ba_riksa');
            $table->string('nomor_ba_tegah');
            $table->string('nomor_ba_segel');
            $table->date('tanggal_sbp');
            $table->string('nomor_surat_perintah');
            $table->date('tanggal_surat_perintah');
            $table->string('nama_pelaku');
            $table->string('jenis_identitas');
            $table->string('nomor_identitas');
            $table->string('lokasi_penindakan');
            $table->string('waktu_penindakan');
            $table->text('alasan_penindakan');
            $table->string('jenis_barang');
            $table->integer('jumlah_barang');
            $table->string('jenis_satuan');
            $table->text('uraian_barang');
            $table->string('nama_petugas_1');
            $table->string('nama_petugas_2');
            $table->foreignId('id_petugas_1')->constrained('petugas');
            $table->foreignId('id_petugas_2')->constrained('petugas');
            $table->integer('nomor_sbp_int');
            $table->string('kota_penindakan');
            $table->string('kecamatan_penindakan');
            $table->boolean('flag_bast')->default(false);
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
