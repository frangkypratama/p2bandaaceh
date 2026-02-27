<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemeriksaan_badan', function (Blueprint $table) {
            $table->id();
            $table->string('no_ba_riksa');
            $table->date('tgl_ba_riksa');
            $table->string('nama');
            $table->string('jenis_identitas');
            $table->string('no_identitas');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('kewarganegaraan');
            $table->text('alamat_pada_identitas');
            $table->text('alamat_tinggal');
            $table->string('datang_dari');
            $table->string('tujuan_ke');
            $table->string('lokasi_pemeriksaan');
            $table->string('jenis_pemeriksaan');
            $table->text('hasil_pemeriksaan');
            $table->string('rekan_perjalanan')->nullable();
            $table->string('nama_sarkut')->nullable();
            $table->string('no_register')->nullable();
            $table->string('jenis_dokumen_barang')->nullable();
            $table->string('nomor_dokumen_barang')->nullable();
            $table->date('tgl_dokumen_barang')->nullable();
            $table->foreignId('id_petugas_1')->constrained('petugas');
            $table->foreignId('id_petugas_2')->nullable()->constrained('petugas');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemeriksaan_badan');
    }
};
