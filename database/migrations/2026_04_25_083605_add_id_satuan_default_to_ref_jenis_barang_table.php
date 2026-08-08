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
        Schema::table('ref_jenis_barang', function (Blueprint $table) {
            $table->unsignedBigInteger('id_satuan_default')->nullable()->after('nama_barang');
            $table->foreign('id_satuan_default')->references('id')->on('ref_satuan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ref_jenis_barang', function (Blueprint $table) {
            $table->dropForeign(['id_satuan_default']);
            $table->dropColumn('id_satuan_default');
        });
    }
};
