<?php

namespace App\Http\Requests;

use App\Models\Sbp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

abstract class BaseSbpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Rule yang sama persis antara form input dan edit SBP.
     */
    protected function baseRules(): array
    {
        return [
            'nomor_sbp' => 'required|integer',
            'tanggal_sbp' => 'required|date',
            'nomor_surat_perintah' => 'required|string|max:255',
            'tanggal_surat_perintah' => 'required|date',
            'nama_pelaku' => 'required|string|max:255',
            'jenis_identitas' => 'required|string|max:255',
            'nomor_identitas' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:255',
            'alamat_di_indonesia' => 'nullable|string',
            'lokasi_penindakan' => 'required|string|max:255',
            'waktu_penindakan' => 'required',
            'alasan_penindakan' => 'required|string',
            'jenis_barang' => 'required|string|max:255',
            'jumlah_barang' => 'required|integer',
            'jenis_satuan' => 'required|string|exists:ref_satuan,nama_satuan',
            'uraian_barang' => 'required|string',
            'kondisi_barang' => 'nullable|string|max:255',
            'id_petugas_1' => 'required|integer|exists:petugas,id',
            'id_petugas_2' => 'required|integer|exists:petugas,id|different:id_petugas_1',
            'kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'flag_bast' => 'nullable|boolean',
            'flag_ba_musnah' => 'nullable|boolean',
            'nomor_ba_musnah' => 'nullable|string|max:255',
        ];
    }

    /**
     * Rule dokumen BAST, hanya berlaku jika flag_bast dicentang.
     */
    protected function bastRules(?int $ignoreBastId = null): array
    {
        if (!$this->boolean('flag_bast')) {
            return [];
        }

        return [
            'nomor_bast' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bast', 'nomor_bast')->ignore($ignoreBastId)->whereNull('deleted_at'),
            ],
            'tanggal_bast' => 'required|date',
            'jenis_dokumen' => 'nullable|string|max:255',
            'tanggal_dokumen' => 'nullable|date',
            'petugas_eksternal' => 'required|string|max:255',
            'nip_nrp_petugas_eksternal' => 'required|string|max:255',
            'instansi_eksternal' => 'required|string|max:255',
            'dalam_rangka' => 'required|string',
        ];
    }

    /**
     * ID Sbp yang harus diabaikan saat cek keunikan nomor_sbp (null saat store).
     */
    protected function ignoreSbpId(): ?int
    {
        return null;
    }

    /**
     * Cek keunikan nomor SBP hasil format (nomor urut + tahun).
     * Error sengaja dilekatkan ke key 'nomor_sbp_final' agar cocok dengan
     * @error('nomor_sbp_final') di view input-sbp/edit-sbp.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (!$this->filled('nomor_sbp') || !$this->filled('tanggal_sbp')) {
                return;
            }

            try {
                $tahun = Carbon::parse($this->input('tanggal_sbp'))->year;
            } catch (\Exception $e) {
                return;
            }

            $formatted = Sbp::formatNomorSbp((int) $this->input('nomor_sbp'), $tahun);

            $exists = Sbp::where('nomor_sbp', $formatted)
                ->whereNull('deleted_at')
                ->when($this->ignoreSbpId(), fn ($q) => $q->where('id', '!=', $this->ignoreSbpId()))
                ->exists();

            if ($exists) {
                $validator->errors()->add('nomor_sbp_final', 'Nomor SBP dengan tahun tersebut sudah ada.');
            }
        });
    }
}
