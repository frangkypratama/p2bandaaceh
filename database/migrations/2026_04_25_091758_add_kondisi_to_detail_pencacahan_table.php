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
        Schema::table('detail_pencacahan', function (Blueprint $table) {
            $table->string('kondisi_barang')->nullable()->after('id_ref_barang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_pencacahan', function (Blueprint $table) {
            $table->dropColumn('kondisi_barang');
        });
    }
};
