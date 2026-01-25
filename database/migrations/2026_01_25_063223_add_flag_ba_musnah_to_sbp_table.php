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
        Schema::table('sbp', function (Blueprint $table) {
            // Menambahkan kolom flag_ba_musnah (boolean, nullable)
            $table->boolean('flag_ba_musnah')->nullable()->after('flag_bast');
            // Menambahkan kolom nomor_ba_musnah (string, nullable)
            $table->string('nomor_ba_musnah')->nullable()->after('flag_ba_musnah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sbp', function (Blueprint $table) {
            // Menghapus kedua kolom jika migrasi di-rollback
            $table->dropColumn(['flag_ba_musnah', 'nomor_ba_musnah']);
        });
    }
};
