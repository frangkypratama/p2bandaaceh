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
        Schema::create('detail_pencacahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pencacahan_sbp_id')->constrained('pencacahan_sbp')->onDelete('cascade');
            $table->foreignId('id_jenis_barang')->constrained('ref_jenis_barang');
            $table->integer('urutan');

            // Foreign keys
            $table->foreignId('id_satuan')->nullable()->constrained('ref_satuan');
            $table->foreignId('id_ref_tarif_cukai')->nullable()->constrained('ref_tarif_cukai');

            // Common Fields
            $table->string('merek')->nullable();
            $table->text('uraian')->nullable();
            $table->unsignedBigInteger('jumlah')->nullable();
            $table->decimal('berat', 15, 4)->nullable();
            $table->decimal('volume', 15, 4)->nullable();

            // Hasil Tembakau
            $table->integer('jumlah_bungkus')->nullable();
            $table->integer('jumlah_batang')->nullable();
            $table->integer('total_batang')->nullable();

            // Handphone, Gadget
            $table->string('imei1')->nullable();
            $table->string('imei2')->nullable();
            $table->string('warna')->nullable();

            // Elektronik, Senjata, Kendaraan, etc.
            $table->string('model_seri')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('tipe')->nullable();
            $table->string('nomor_rangka')->nullable();
            $table->string('nomor_mesin')->nullable();
            $table->string('jenis_elektronik')->nullable(); 

            // MMEA / Etil Alkohol
            $table->decimal('kadar_alkohol', 5, 2)->nullable();
            $table->integer('jumlah_botol')->nullable();

            // NPP, CITES, Bahan Kimia
            $table->string('nama_zat')->nullable();
            $table->string('jenis_zat')->nullable();
            $table->string('bentuk_sediaan')->nullable();
            $table->integer('jumlah_kemasan')->nullable();
            
            // Kendaraan, Senjata, Uang, MMEA, dll
            $table->string('jenis_kendaraan')->nullable();
            $table->string('jenis_mmea')->nullable();
            $table->string('jenis_rokok')->nullable();
            $table->string('mata_uang')->nullable();

            // Pita Cukai
            $table->year('tahun')->nullable();
            
            // Kosmetik, Alkes, HAKI
            $table->string('nama_produk')->nullable();
            $table->string('no_izin_edar')->nullable();
            $table->date('tanggal_kadaluwarsa')->nullable();
            $table->string('no_bpom')->nullable();

            // Obat-obatan
            $table->string('nama_obat')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pencacahan');
    }
};
