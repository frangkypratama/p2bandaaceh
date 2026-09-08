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
            $table->boolean('pelaku_tidak_ditemukan')->default(false)->after('nama_tempat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lphp', function (Blueprint $table) {
            $table->dropColumn('pelaku_tidak_ditemukan');
        });
    }
};
