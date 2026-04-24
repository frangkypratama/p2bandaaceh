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
        if (!Schema::hasTable('pencacahan')) {
            Schema::create('pencacahan', function (Blueprint $table) {
                $table->id();
                $table->string('no_ba_cacah')->unique();
                $table->date('tanggal_ba_cacah');
                $table->string('no_surat_tugas_pencacahan')->nullable();
                $table->date('tanggal_surat_tugas_pencacahan')->nullable();
                $table->string('giat')->nullable();
                $table->string('lokasi_cacah')->nullable();
                $table->unsignedBigInteger('id_petugas_1');
                $table->unsignedBigInteger('id_petugas_2')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencacahan');
    }
};
