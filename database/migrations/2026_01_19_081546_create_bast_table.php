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
        Schema::create('bast', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_bast');
            $table->date('tanggal_bast');
            $table->string('jenis_dokumen');
            $table->date('tanggal_dokumen');
            $table->string('petugas_eksternal');
            $table->string('nip_nrp_petugas_eksternal');
            $table->string('instansi_eksternal');
            $table->text('dalam_rangka');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bast');
    }
};
