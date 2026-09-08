<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('lphp')->where('dugaan_pelanggaran', 'Pabean')->update(['dugaan_pelanggaran' => 'Kepabeanan']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('lphp')->where('dugaan_pelanggaran', 'Kepabeanan')->update(['dugaan_pelanggaran' => 'Pabean']);
    }
};
