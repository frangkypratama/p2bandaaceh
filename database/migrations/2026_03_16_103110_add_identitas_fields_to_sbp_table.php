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
        Schema::table('sbp', function (Blueprint $table) {
            $table->string('no_hp')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->text('alamat_di_indonesia')->nullable();
            $table->string('kondisi_barang')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sbp', function (Blueprint $table) {
            $table->dropColumn(['no_hp', 'jenis_kelamin', 'alamat_di_indonesia', 'kondisi_barang']);
        });
    }
};
