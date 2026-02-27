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
        Schema::table('pemeriksaan_badan', function (Blueprint $table) {
            $table->string('no_surat_perintah')->nullable()->after('tgl_ba_riksa');
            $table->date('tgl_surat_perintah')->nullable()->after('no_surat_perintah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pemeriksaan_badan', function (Blueprint $table) {
            $table->dropColumn(['no_surat_perintah', 'tgl_surat_perintah']);
        });
    }
};
