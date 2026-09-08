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
            $table->text('uraian_kegiatan')->nullable()->after('dugaan_pelanggaran');
        });

        // Backfill data yang sudah ada supaya tidak kehilangan narasi yang sebelumnya
        // dirangkai otomatis dari nama_tempat + alasan_penindakan SBP.
        DB::table('lphp')
            ->join('sbp', 'sbp.id', '=', 'lphp.sbp_id')
            ->whereNull('lphp.uraian_kegiatan')
            ->select('lphp.id', 'lphp.nama_tempat', 'sbp.alasan_penindakan')
            ->get()
            ->each(function ($row) {
                $tempat = $row->nama_tempat ?: '-';
                $alasan = $row->alasan_penindakan ?: 'membawa/menjual/memiliki barang kena cukai ilegal';

                DB::table('lphp')->where('id', $row->id)->update([
                    'uraian_kegiatan' => "Dilakukan pemeriksaan terhadap {$tempat} yang diindikasikan {$alasan}",
                ]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lphp', function (Blueprint $table) {
            $table->dropColumn('uraian_kegiatan');
        });
    }
};
