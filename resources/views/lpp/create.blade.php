@extends('layouts.app')

@section('content')
    @php $lphp = $lp->lphp; $sbp = optional($lphp)->sbp; @endphp
    <div class="container-lg">
        <form action="{{ route('lpp.store') }}" method="POST" id="lppForm">
            @csrf
            <input type="hidden" name="lp_id" value="{{ $lp->id }}">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0 d-flex align-items-center">
                        <i class="cil-plus me-2"></i>
                        <span><strong>Buat Lembar Penerimaan Perkara (LPP)</strong></span>
                    </h4>
                    <small class="text-medium-emphasis-white">Tindak lanjut atas LP {{ $lp->nomor_lp }}.</small>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">

                        {{-- Data LP (read-only) --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-file me-2"></i>Data LP (Referensi)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nomor LP</label>
                                            <input type="text" class="form-control" value="{{ $lp->nomor_lp }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal LP</label>
                                            <input type="text" class="form-control" value="{{ optional($lp->tanggal_lp)->translatedFormat('d F Y') }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Nomor SBP</label>
                                            <input type="text" class="form-control" value="{{ optional($sbp)->nomor_sbp }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Diduga Dilakukan Oleh</label>
                                            <input type="text" class="form-control" value="{{ optional($sbp)->nama_pelaku ?? '-' }} ({{ optional($sbp)->nomor_identitas ?? '-' }})" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Detail LPP --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-notes me-2"></i>Detail Lembar Penerimaan Perkara</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="tanggal_lpp" class="form-label">Tanggal LPP</label>
                                            <input type="date" class="form-control @error('tanggal_lpp') is-invalid @enderror"
                                                   id="tanggal_lpp" name="tanggal_lpp" value="{{ old('tanggal_lpp', optional($lp->tanggal_lp)->format('Y-m-d')) }}" required>
                                            @error('tanggal_lpp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="asal_perkara" class="form-label">Asal Perkara</label>
                                            <input type="text" class="form-control @error('asal_perkara') is-invalid @enderror"
                                                   id="asal_perkara" name="asal_perkara" value="{{ old('asal_perkara', 'Unit Penindakan') }}" required>
                                            @error('asal_perkara')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="jenis_penindakan" class="form-label">Jenis Penindakan</label>
                                            <input type="text" class="form-control @error('jenis_penindakan') is-invalid @enderror"
                                                   id="jenis_penindakan" name="jenis_penindakan" value="{{ old('jenis_penindakan', 'Penegahan') }}" required>
                                            @error('jenis_penindakan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="status_pelanggaran" class="form-label">Status Pelanggaran</label>
                                            <input type="text" class="form-control @error('status_pelanggaran') is-invalid @enderror"
                                                   id="status_pelanggaran" name="status_pelanggaran" value="{{ old('status_pelanggaran', 'Tertangkap Tangan') }}" required>
                                            @error('status_pelanggaran')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="uraian_pelanggaran" class="form-label">Uraian Pelanggaran</label>
                                            <textarea class="form-control @error('uraian_pelanggaran') is-invalid @enderror"
                                                      id="uraian_pelanggaran" name="uraian_pelanggaran" rows="3"
                                                      required>{{ old('uraian_pelanggaran', optional($sbp)->alasan_penindakan) }}</textarea>
                                            @error('uraian_pelanggaran')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="dokumen_barang" class="form-label">Dokumen Barang (opsional)</label>
                                            <textarea class="form-control @error('dokumen_barang') is-invalid @enderror"
                                                      id="dokumen_barang" name="dokumen_barang" rows="2">{{ old('dokumen_barang') }}</textarea>
                                            @error('dokumen_barang')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="catatan_atasan" class="form-label">Catatan Atasan Pembuat LPP (opsional)</label>
                                            <textarea class="form-control @error('catatan_atasan') is-invalid @enderror"
                                                      id="catatan_atasan" name="catatan_atasan" rows="2">{{ old('catatan_atasan') }}</textarea>
                                            @error('catatan_atasan')
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
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-people me-2"></i>Penandatangan LPP</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="konseptor_id" class="form-label">Konseptor LPP</label>
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
                                            <label for="pengampu_id" class="form-label">Mengetahui, Kepala Seksi Penindakan dan Penyidikan</label>
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
                                            <label for="pemeriksa_id" class="form-label">Yang Membuat LPP, Pemeriksa Bea dan Cukai</label>
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
                    <a href="{{ route('lp.index') }}" class="btn btn-secondary">
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
