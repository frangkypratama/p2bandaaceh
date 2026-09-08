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
        Schema::create('lp', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lphp_id')->nullable();
            $table->foreign('lphp_id')->references('id')->on('lphp')->onDelete('set null');

            $table->string('nomor_lp');

            // Kolom bayangan, pola yang sama dengan sbp_id_active di tabel lphp:
            // mencegah satu LPHP memiliki lebih dari satu LP aktif, sekaligus tetap
            // mengizinkan lphp_id yang sama dipakai lagi setelah LP lama di-soft-delete.
            $table->unsignedBigInteger('lphp_id_active')->nullable()->unique();

            $table->date('tanggal_lp');

            $table->unsignedBigInteger('pejabat_penerbit_id');
            $table->foreign('pejabat_penerbit_id')->references('id')->on('petugas');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lp');
    }
};
