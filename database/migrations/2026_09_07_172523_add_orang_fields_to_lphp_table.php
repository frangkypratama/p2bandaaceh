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
        Schema::table('lphp', function (Blueprint $table) {
            $table->date('tanggal_lahir')->nullable()->after('nama_tempat');
            $table->string('kewarganegaraan')->default('Indonesia')->after('tanggal_lahir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lphp', function (Blueprint $table) {
            $table->dropColumn(['tanggal_lahir', 'kewarganegaraan']);
        });
    }
};
