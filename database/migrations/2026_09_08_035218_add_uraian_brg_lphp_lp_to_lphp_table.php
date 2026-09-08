<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lphp', function (Blueprint $table) {
            $table->text('uraian_brg_lphp_lp')->nullable()->after('uraian_kegiatan');
        });

        // Backfill data yang sudah ada dari uraian_barang milik SBP terkait,
        // supaya tidak kehilangan data saat kolom ini mulai dipakai di template.
        DB::table('lphp')
            ->join('sbp', 'sbp.id', '=', 'lphp.sbp_id')
            ->whereNull('lphp.uraian_brg_lphp_lp')
            ->select('lphp.id', 'sbp.uraian_barang')
            ->get()
            ->each(function ($row) {
                DB::table('lphp')->where('id', $row->id)->update([
                    'uraian_brg_lphp_lp' => $row->uraian_barang,
                ]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lphp', function (Blueprint $table) {
            $table->dropColumn('uraian_brg_lphp_lp');
        });
    }
};
