@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <form action="{{ route('lphp.store') }}" method="POST" id="lphpForm">
            @csrf
            <input type="hidden" name="sbp_id" value="{{ $selectedSbp->id }}">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0 d-flex align-items-center">
                        <i class="cil-plus me-2"></i>
                        <span><strong>Buat Lembar Penentuan Hasil Penindakan (LPHP)</strong></span>
                    </h4>
                    <small class="text-medium-emphasis-white">Tindak lanjut atas SBP.</small>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">

                        {{-- Pilih SBP --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-file me-2"></i>Data SBP (Referensi)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nomor SBP</label>
                                            <input type="text" class="form-control" readonly value="{{ $selectedSbp->nomor_sbp }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal SBP</label>
                                            <input type="text" class="form-control" readonly
                                                   value="{{ optional($selectedSbp->tanggal_sbp)->translatedFormat('d F Y') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Jenis Barang</label>
                                            <input type="text" class="form-control" readonly value="{{ $selectedSbp->jenis_barang }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Jumlah Barang</label>
                                            <input type="text" class="form-control" readonly
                                                   value="{{ $selectedSbp->jumlah_barang }} {{ $selectedSbp->jenis_satuan }}">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Uraian Barang</label>
                                            <textarea class="form-control" rows="2" readonly>{{ $selectedSbp->uraian_barang }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Detail Pelaku --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-user me-2"></i>Detail Pelaku</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Pelaku</label>
                                            <input type="text" class="form-control" readonly value="{{ $selectedSbp->nama_pelaku }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Identitas</label>
                                            <input type="text" class="form-control" readonly
                                                   value="{{ $selectedSbp->jenis_identitas }} / {{ $selectedSbp->nomor_identitas }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir Pelaku</label>
                                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                   id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                            @error('tanggal_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                                            <select class="form-select @error('kewarganegaraan') is-invalid @enderror"
                                                    id="kewarganegaraan" name="kewarganegaraan">
                                                @foreach($nationalities as $nationality)
                                                    <option value="{{ $nationality }}" {{ old('kewarganegaraan', 'Indonesia') == $nationality ? 'selected' : '' }}>
                                                        {{ $nationality }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('kewarganegaraan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Detail LPHP --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-notes me-2"></i>Detail LPHP</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nomor LPHP</label>
                                            <input type="text" class="form-control" readonly value="{{ $previewNomorLphp }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tanggal_lphp" class="form-label">Tanggal LPHP</label>
                                            <input type="date" class="form-control @error('tanggal_lphp') is-invalid @enderror"
                                                   id="tanggal_lphp" name="tanggal_lphp" value="{{ old('tanggal_lphp', optional($selectedSbp->tanggal_sbp)->format('Y-m-d')) }}" required>
                                            @error('tanggal_lphp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @php
                                            $defaultPasal = $categoryDefaults[$defaultDugaanPelanggaran]['pasal'];
                                            $defaultUuTerkait = $categoryDefaults[$defaultDugaanPelanggaran]['uu_terkait'];
                                            $defaultUraianKegiatan = $categoryDefaults[$defaultDugaanPelanggaran]['uraian_kegiatan'];
                                        @endphp
                                        <div class="col-md-6">
                                            <label for="dugaan_pelanggaran" class="form-label">Dugaan Pelanggaran</label>
                                            <select class="form-select @error('dugaan_pelanggaran') is-invalid @enderror"
                                                    id="dugaan_pelanggaran" name="dugaan_pelanggaran" required>
                                                <option value="Cukai" {{ old('dugaan_pelanggaran', $defaultDugaanPelanggaran) == 'Cukai' ? 'selected' : '' }}>Cukai</option>
                                                <option value="Pabean" {{ old('dugaan_pelanggaran', $defaultDugaanPelanggaran) == 'Pabean' ? 'selected' : '' }}>Pabean</option>
                                            </select>
                                            @error('dugaan_pelanggaran')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="pasal" class="form-label">Pasal</label>
                                            <input type="text" class="form-control @error('pasal') is-invalid @enderror"
                                                   id="pasal" name="pasal" value="{{ old('pasal', $defaultPasal) }}"
                                                   placeholder="Contoh: Pasal 56" required>
                                            @error('pasal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="uu_terkait" class="form-label">Undang-Undang Terkait</label>
                                            <textarea class="form-control @error('uu_terkait') is-invalid @enderror"
                                                      id="uu_terkait" name="uu_terkait" rows="2"
                                                      required>{{ old('uu_terkait', $defaultUuTerkait) }}</textarea>
                                            @error('uu_terkait')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="uraian_kegiatan" class="form-label">Kegiatan Penindakan</label>
                                            <textarea class="form-control @error('uraian_kegiatan') is-invalid @enderror"
                                                      id="uraian_kegiatan" name="uraian_kegiatan" rows="2"
                                                      required>{{ old('uraian_kegiatan', $defaultUraianKegiatan) }}</textarea>
                                            @error('uraian_kegiatan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="uraian_brg_lphp_lp" class="form-label">Uraian Barang (untuk LPHP/LP)</label>
                                            <textarea class="form-control @error('uraian_brg_lphp_lp') is-invalid @enderror"
                                                      id="uraian_brg_lphp_lp" name="uraian_brg_lphp_lp" rows="2"
                                                      required>{{ old('uraian_brg_lphp_lp', $selectedSbp->uraian_barang) }}</textarea>
                                            @error('uraian_brg_lphp_lp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-8">
                                            <label for="nama_tempat" class="form-label">Nama Tempat / Toko</label>
                                            <input type="text" class="form-control @error('nama_tempat') is-invalid @enderror"
                                                   id="nama_tempat" name="nama_tempat" value="{{ old('nama_tempat', $defaultNamaTempat) }}"
                                                   placeholder="Contoh: Toko Nay Jaya">
                                            @error('nama_tempat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                       id="pelaku_tidak_ditemukan" name="pelaku_tidak_ditemukan"
                                                       {{ old('pelaku_tidak_ditemukan') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pelaku_tidak_ditemukan">
                                                    Pelaku tidak ditemukan
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="catatan" class="form-label">Catatan (opsional)</label>
                                            <textarea class="form-control @error('catatan') is-invalid @enderror"
                                                      id="catatan" name="catatan" rows="2">{{ old('catatan') }}</textarea>
                                            @error('catatan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Penandatangan --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-people me-2"></i>Penandatangan LPHP</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="konseptor_id" class="form-label">Konseptor LPHP</label>
                                            <select class="form-select @error('konseptor_id') is-invalid @enderror" id="konseptor_id" name="konseptor_id" required>
                                                <option value="" disabled selected>Pilih Petugas...</option>
                                                @foreach($petugasData as $petugas)
                                                    <option value="{{ $petugas->id }}" {{ old('konseptor_id') == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('konseptor_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="pengampu_id" class="form-label">Pengampu Pejabat Penyusun LPHP</label>
                                            <select class="form-select @error('pengampu_id') is-invalid @enderror" id="pengampu_id" name="pengampu_id" required>
                                                <option value="" disabled selected>Pilih Petugas...</option>
                                                @foreach($petugasData as $petugas)
                                                    <option value="{{ $petugas->id }}" {{ old('pengampu_id') == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('pengampu_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="pemeriksa_id" class="form-label">Pemeriksa Bea dan Cukai Ahli Pertama</label>
                                            <select class="form-select @error('pemeriksa_id') is-invalid @enderror" id="pemeriksa_id" name="pemeriksa_id" required>
                                                <option value="" disabled selected>Pilih Petugas...</option>
                                                @foreach($petugasData as $petugas)
                                                    <option value="{{ $petugas->id }}" {{ old('pemeriksa_id') == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('pemeriksa_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-end bg-light">
                    <a href="{{ route('lphp.index') }}" class="btn btn-secondary">
                        <i class="cil-x-circle me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="cil-save me-2"></i>Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
<style>
    .text-medium-emphasis-white {
        color: rgba(255, 255, 255, 0.7) !important;
    }
    .card .card-header h5 {
        font-size: 1.1rem;
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    $('#kewarganegaraan').select2({
        theme: 'bootstrap-5',
        placeholder: 'Pilih Kewarganegaraan',
        width: '100%',
    });

    // Satu sumber kebenaran: dikirim dari LphpController (Lphp::categoryDefaults),
    // bukan duplikat aturan bisnis di JS.
    var categoryDefaults = @json($categoryDefaults);

    document.getElementById('dugaan_pelanggaran').addEventListener('change', function () {
        var defaults = categoryDefaults[this.value];
        if (defaults) {
            document.getElementById('pasal').value = defaults.pasal;
            document.getElementById('uu_terkait').value = defaults.uu_terkait;
            document.getElementById('uraian_kegiatan').value = defaults.uraian_kegiatan;
        }
    });
});
</script>
@endpush
