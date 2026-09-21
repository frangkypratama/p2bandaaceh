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
        Schema::create('split', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lpf_id')->nullable();
            $table->foreign('lpf_id')->references('id')->on('lpf')->onDelete('set null');

            $table->string('nomor_split');

            // Kolom bayangan, pola yang sama dengan lpp_id_active di tabel lpf:
            // mencegah satu LPF memiliki lebih dari satu SPLIT aktif, sekaligus tetap
            // mengizinkan lpf_id yang sama dipakai lagi setelah SPLIT lama di-soft-delete.
            $table->unsignedBigInteger('lpf_id_active')->nullable()->unique();

            $table->date('tanggal_split');
            $table->text('dasar');
            $table->text('pertimbangan');

            $table->unsignedBigInteger('petugas1_id');
            $table->foreign('petugas1_id')->references('id')->on('petugas');

            $table->unsignedBigInteger('petugas2_id');
            $table->foreign('petugas2_id')->references('id')->on('petugas');

            $table->text('uraian_tugas')->nullable();

            $table->unsignedBigInteger('penerbit_id');
            $table->foreign('penerbit_id')->references('id')->on('petugas');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('split');
    }
};
