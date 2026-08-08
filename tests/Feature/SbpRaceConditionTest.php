<?php

namespace Tests\Feature;

use App\Http\Requests\StoreSbpRequest;
use App\Models\Petugas;
use App\Models\RefSatuan;
use App\Models\Sbp;
use App\Services\SbpService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Tests\TestCase;

class SbpRaceConditionTest extends TestCase
{
    use RefreshDatabase;

    private Petugas $petugas1;
    private Petugas $petugas2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->petugas1 = Petugas::create([
            'nama' => 'Petugas Satu',
            'nip' => '111111',
            'pangkat' => 'Pangkat',
            'golongan' => 'III/a',
            'jabatan' => 'Jabatan',
        ]);

        $this->petugas2 = Petugas::create([
            'nama' => 'Petugas Dua',
            'nip' => '222222',
            'pangkat' => 'Pangkat',
            'golongan' => 'III/a',
            'jabatan' => 'Jabatan',
        ]);

        RefSatuan::create(['nama_satuan' => 'KG']);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'nomor_sbp' => 500,
            'tanggal_sbp' => '2026-01-10',
            'nomor_surat_perintah' => 'PRIN-1',
            'tanggal_surat_perintah' => '2026-01-10',
            'nama_pelaku' => 'Pelaku Uji',
            'jenis_identitas' => 'KTP',
            'nomor_identitas' => '12345',
            'lokasi_penindakan' => 'Lokasi Uji',
            'waktu_penindakan' => '10:00',
            'alasan_penindakan' => 'Alasan Uji',
            'jenis_barang' => 'Barang Uji',
            'jumlah_barang' => 1,
            'jenis_satuan' => 'KG',
            'uraian_barang' => 'Uraian Uji',
            'id_petugas_1' => $this->petugas1->id,
            'id_petugas_2' => $this->petugas2->id,
            'kota' => 'Kota Uji',
            'kecamatan' => 'Kecamatan Uji',
        ], $overrides);
    }

    /** Alur normal: submit sekali harus tetap berhasil seperti sebelum refactor. */
    public function test_store_sbp_via_http_masih_berhasil(): void
    {
        $response = $this->post(route('sbp.store'), $this->payload());

        $response->assertRedirect(route('sbp.index'));
        $this->assertDatabaseCount('sbp', 1);

        $sbp = Sbp::first();
        $this->assertSame('SBP-500/KBC.0102/2026', $sbp->nomor_sbp);
        $this->assertSame('SBP-500/KBC.0102/2026', $sbp->nomor_sbp_active);
    }

    /** Submit dua kali berurutan (bukan race) tetap ditolak lewat validasi form seperti biasa. */
    public function test_submit_nomor_sbp_yang_sama_berurutan_ditolak_validasi(): void
    {
        $this->post(route('sbp.store'), $this->payload());
        $response = $this->post(route('sbp.store'), $this->payload());

        $response->assertSessionHasErrors(['nomor_sbp_final']);
        $this->assertDatabaseCount('sbp', 1);
    }

    /**
     * Simulasi race condition sesungguhnya: request lolos pengecekan "belum ada" di
     * FormRequest, tapi tepat setelah itu, request lain ("pemenang race") berhasil
     * commit duluan dengan nomor yang sama. SbpService harus mendeteksi tabrakan lewat
     * unique index nomor_sbp_active, lalu OTOMATIS mencoba nomor berikutnya (+1) dan
     * berhasil menyimpan tanpa membuat duplikat maupun menyuruh user submit ulang.
     */
    public function test_race_condition_otomatis_naik_nomor_dan_ditandai_auto_adjusted(): void
    {
        $request = StoreSbpRequest::create(
            route('sbp.store'),
            SymfonyRequest::METHOD_POST,
            $this->payload()
        );
        $request->setContainer(app());
        // Belum ada baris sama sekali, jadi validasi (termasuk cek unik) pasti lolos.
        $request->validateResolved();

        // "Request lain" menang duluan dan berhasil commit tepat setelah validasi di atas.
        $winner = DB::transaction(fn () => Sbp::create($this->rowData(500, 'Pemenang Race')));
        $this->assertSame('SBP-500/KBC.0102/2026', $winner->nomor_sbp_active);

        $result = app(SbpService::class)->store($request);

        $this->assertTrue($result['auto_adjusted']);
        $this->assertSame(500, $result['requested_nomor']);
        $this->assertSame(501, $result['final_nomor']);
        $this->assertSame('SBP-501/KBC.0102/2026', $result['sbp']->nomor_sbp);

        // Dua baris: milik pemenang race (500) dan hasil auto-retry (501) — tidak ada duplikat.
        $this->assertDatabaseCount('sbp', 2);
    }

    /**
     * Kalau nomor 500 s.d. 504 SEMUANYA sudah dipakai (menghabiskan seluruh jatah retry),
     * SbpService wajib menyerah dengan ValidationException yang rapi (bukan retry selamanya
     * atau error 500), supaya user diminta submit ulang secara sadar.
     */
    public function test_race_condition_setelah_retry_habis_tetap_gagal_rapi(): void
    {
        $request = StoreSbpRequest::create(
            route('sbp.store'),
            SymfonyRequest::METHOD_POST,
            $this->payload()
        );
        $request->setContainer(app());
        $request->validateResolved();

        // Nomor 500 (yang diminta) s.d. 504 sudah dipakai semua = 5 kali tabrakan berturut-turut.
        foreach (range(500, 504) as $nomor) {
            DB::transaction(fn () => Sbp::create($this->rowData($nomor, "Pemegang Nomor {$nomor}")));
        }
        $this->assertDatabaseCount('sbp', 5);

        try {
            app(SbpService::class)->store($request);
            $this->fail('SbpService seharusnya menyerah setelah retry habis.');
        } catch (ValidationException $e) {
            $this->assertArrayHasKey('nomor_sbp_final', $e->errors());
        }

        // Tidak ada baris baru yang nyasar tersimpan.
        $this->assertDatabaseCount('sbp', 5);
    }

    /**
     * Uji khusus lapisan controller: kalau SbpService melaporkan nomor sempat disesuaikan
     * otomatis (auto_adjusted), controller wajib menampilkan notifikasi 'warning' berisi
     * nomor final ke user. SbpService di-mock supaya test ini murni menguji logika
     * redirect+flash di SbpController::redirectAfterSave(), terlepas dari cara SbpService
     * mendeteksi race condition-nya (sudah dibuktikan lewat test-test di atas).
     */
    public function test_notifikasi_warning_muncul_saat_hasil_service_auto_adjusted(): void
    {
        $sbp = Sbp::make($this->rowData(501, 'Uji Notifikasi'));

        $this->mock(SbpService::class, function ($mock) use ($sbp) {
            $mock->shouldReceive('store')->once()->andReturn([
                'sbp' => $sbp,
                'requested_nomor' => 500,
                'final_nomor' => 501,
                'auto_adjusted' => true,
            ]);
        });

        $response = $this->post(route('sbp.store'), $this->payload());

        $response->assertRedirect(route('sbp.index'));
        $response->assertSessionHas('warning');
        $this->assertStringContainsString('SBP-501/KBC.0102/2026', session('warning'));
        $this->assertStringContainsString('500', session('warning'));
    }

    private function rowData(int $nomorInt, string $namaPelaku): array
    {
        return [
            'nomor_sbp' => "SBP-{$nomorInt}/KBC.0102/2026",
            'nomor_ba_riksa' => "BA-{$nomorInt}/RIKSA/KBC.010202/2026",
            'nomor_ba_tegah' => "BA-{$nomorInt}/TEGAH/KBC.010202/2026",
            'nomor_ba_segel' => "BA-{$nomorInt}/SEGEL/KBC.010202/2026",
            'tanggal_sbp' => '2026-01-10',
            'nomor_surat_perintah' => "PRIN-{$nomorInt}",
            'tanggal_surat_perintah' => '2026-01-10',
            'nama_pelaku' => $namaPelaku,
            'jenis_identitas' => 'KTP',
            'nomor_identitas' => '99999',
            'lokasi_penindakan' => 'Lokasi',
            'waktu_penindakan' => '11:00',
            'alasan_penindakan' => 'Alasan',
            'jenis_barang' => 'Barang',
            'jumlah_barang' => 1,
            'jenis_satuan' => 'KG',
            'uraian_barang' => 'Uraian',
            'nama_petugas_1' => $this->petugas1->nama,
            'nama_petugas_2' => $this->petugas2->nama,
            'id_petugas_1' => $this->petugas1->id,
            'id_petugas_2' => $this->petugas2->id,
            'nomor_sbp_int' => $nomorInt,
            'kota_penindakan' => 'Kota',
            'kecamatan_penindakan' => 'Kecamatan',
        ];
    }
}
