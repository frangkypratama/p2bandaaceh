<?php

namespace App\Services;

use App\Http\Requests\StoreSbpRequest;
use App\Http\Requests\UpdateSbpRequest;
use App\Models\Petugas;
use App\Models\Sbp;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SbpService
{
    /**
     * Batas percobaan naikkan nomor +1 saat kena race condition, sebelum akhirnya
     * menyerah dan meminta user submit ulang secara manual.
     */
    private const MAX_NOMOR_RETRY_ATTEMPTS = 5;

    public function store(StoreSbpRequest $request): array
    {
        $validated = $request->validated();
        $requestedNomor = (int) $validated['nomor_sbp'];

        return $this->saveWithNomorRetry($requestedNomor, function (int $nomor) use ($validated, $request) {
            return DB::transaction(function () use ($validated, $request, $nomor) {
                $sbp = Sbp::create($this->prepareData($validated, $request, $nomor));

                if ($request->boolean('flag_bast')) {
                    $sbp->bast()->create($this->bastData($request));
                }

                return $sbp;
            });
        });
    }

    public function update(Sbp $sbp, UpdateSbpRequest $request): array
    {
        $validated = $request->validated();
        $requestedNomor = (int) $validated['nomor_sbp'];

        return $this->saveWithNomorRetry($requestedNomor, function (int $nomor) use ($sbp, $validated, $request) {
            return DB::transaction(function () use ($sbp, $validated, $request, $nomor) {
                $sbp->update($this->prepareData($validated, $request, $nomor));

                if ($request->boolean('delete_bast') && $sbp->bast) {
                    $sbp->bast->delete();
                } elseif ($request->boolean('flag_bast')) {
                    $sbp->bast()->updateOrCreate(['sbp_id' => $sbp->id], $this->bastData($request));
                }

                return $sbp;
            });
        });
    }

    /**
     * Jalankan $attempt(nomor) dengan nomor yang diminta user. Kalau nomor itu direbut
     * proses lain tepat setelah lolos validasi (race condition, terdeteksi lewat unique
     * index nomor_sbp_active di database), otomatis coba lagi dengan nomor berikutnya
     * sampai MAX_NOMOR_RETRY_ATTEMPTS kali. Hasilnya memberi tahu pemanggil apakah nomor
     * sempat disesuaikan otomatis, supaya user bisa dinotifikasi.
     *
     * @return array{sbp: Sbp, requested_nomor: int, final_nomor: int, auto_adjusted: bool}
     */
    private function saveWithNomorRetry(int $requestedNomor, callable $attempt): array
    {
        $nomor = $requestedNomor;

        for ($i = 0; $i < self::MAX_NOMOR_RETRY_ATTEMPTS; $i++) {
            try {
                $sbp = $attempt($nomor);

                return [
                    'sbp' => $sbp,
                    'requested_nomor' => $requestedNomor,
                    'final_nomor' => $nomor,
                    'auto_adjusted' => $nomor !== $requestedNomor,
                ];
            } catch (UniqueConstraintViolationException $e) {
                $nomor++;
            }
        }

        throw $this->duplicateNomorSbpException();
    }

    /**
     * Terjemahkan pelanggaran unique index nomor_sbp_active jadi error validasi yang
     * dipahami form (key nomor_sbp_final, sama seperti pengecekan awal di FormRequest).
     * Dipakai kalau retry +1 masih tetap kena tabrakan berkali-kali.
     */
    private function duplicateNomorSbpException(): ValidationException
    {
        return ValidationException::withMessages([
            'nomor_sbp_final' => 'Nomor SBP dengan tahun tersebut sudah ada.',
        ]);
    }

    /**
     * Susun data Sbp siap simpan: input tervalidasi + nomor hasil format + nama petugas.
     */
    private function prepareData(array $validated, StoreSbpRequest|UpdateSbpRequest $request, int $nomorSbpInt): array
    {
        $tahunSbp = Carbon::parse($validated['tanggal_sbp'])->year;

        $petugas1 = Petugas::find($validated['id_petugas_1']);
        $petugas2 = Petugas::find($validated['id_petugas_2']);

        return array_merge(
            $validated,
            Sbp::buildNomorSet($nomorSbpInt, $tahunSbp),
            [
                'kota_penindakan' => $validated['kota'],
                'kecamatan_penindakan' => $validated['kecamatan'],
                'nama_petugas_1' => $petugas1->nama,
                'nama_petugas_2' => $petugas2->nama,
                'nomor_sbp_int' => $nomorSbpInt,
                'flag_bast' => $request->boolean('flag_bast'),
                'flag_ba_musnah' => $request->boolean('flag_ba_musnah'),
                'nomor_ba_musnah' => $request->boolean('flag_ba_musnah') ? ($validated['nomor_ba_musnah'] ?? null) : null,
            ]
        );
    }

    private function bastData(StoreSbpRequest|UpdateSbpRequest $request): array
    {
        return $request->only([
            'nomor_bast',
            'tanggal_bast',
            'jenis_dokumen',
            'tanggal_dokumen',
            'petugas_eksternal',
            'nip_nrp_petugas_eksternal',
            'instansi_eksternal',
            'dalam_rangka',
        ]);
    }
}
