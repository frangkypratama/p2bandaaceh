@extends('layouts.app')

@section('content')
    @php
        $lpp = $lpf->lpp; $lp = optional($lpp)->lp; $lphp = optional($lp)->lphp; $sbp = optional($lphp)->sbp;
    @endphp
    <div class="container-lg">
        <form action="{{ route('lpf.update', $lpf->id) }}" method="POST" id="lpfForm">
            @csrf
            @method('PUT')

            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="card-title mb-0 d-flex align-items-center">
                        <i class="cil-pencil me-2"></i>
                        <span><strong>Edit {{ $lpf->nomor_lpf }}</strong></span>
                    </h4>
                    <small class="text-muted">Tindak lanjut atas LPP {{ optional($lpp)->nomor_lpp }}.</small>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">

                        {{-- Data LPP (read-only) --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-file me-2"></i>Data LPP (Referensi)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nomor LPP</label>
                                            <input type="text" class="form-control" value="{{ optional($lpp)->nomor_lpp }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Nomor LP</label>
                                            <input type="text" class="form-control" value="{{ optional($lp)->nomor_lp }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Diduga Dilakukan Oleh</label>
                                            <input type="text" class="form-control" value="{{ optional($sbp)->nama_pelaku ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- A-B. Uraian & Kelengkapan --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-notes me-2"></i>A-B. Uraian Pelanggaran &amp; Kelengkapan Dokumen</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="tanggal_lpf" class="form-label">Tanggal LPF</label>
                                            <input type="date" class="form-control @error('tanggal_lpf') is-invalid @enderror"
                                                   id="tanggal_lpf" name="tanggal_lpf" value="{{ old('tanggal_lpf', $lpf->tanggal_lpf->format('Y-m-d')) }}" required>
                                            @error('tanggal_lpf')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="status_penangkapan" class="form-label">Status Penangkapan</label>
                                            <input type="text" class="form-control @error('status_penangkapan') is-invalid @enderror"
                                                   id="status_penangkapan" name="status_penangkapan" value="{{ old('status_penangkapan', $lpf->status_penangkapan) }}" required>
                                            @error('status_penangkapan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="kelengkapan_dokumen" class="form-label">Kelengkapan Dokumen Penindakan</label>
                                            <textarea class="form-control @error('kelengkapan_dokumen') is-invalid @enderror"
                                                      id="kelengkapan_dokumen" name="kelengkapan_dokumen" rows="4"
                                                      required>{{ old('kelengkapan_dokumen', $lpf->kelengkapan_dokumen) }}</textarea>
                                            @error('kelengkapan_dokumen')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="barang_hasil_penindakan" class="form-label">Barang Hasil Penindakan (opsional)</label>
                                            <textarea class="form-control @error('barang_hasil_penindakan') is-invalid @enderror"
                                                      id="barang_hasil_penindakan" name="barang_hasil_penindakan" rows="3">{{ old('barang_hasil_penindakan', $lpf->barang_hasil_penindakan) }}</textarea>
                                            @error('barang_hasil_penindakan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- D-F. Kesimpulan --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-check-circle me-2"></i>D-F. Kesimpulan, Usulan &amp; Disposisi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label for="domain_perkara" class="form-label">Domain Perkara</label>
                                            <textarea class="form-control @error('domain_perkara') is-invalid @enderror"
                                                      id="domain_perkara" name="domain_perkara" rows="2"
                                                      required>{{ old('domain_perkara', $lpf->domain_perkara) }}</textarea>
                                            @error('domain_perkara')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="kesimpulan" class="form-label">Kesimpulan</label>
                                            <textarea class="form-control @error('kesimpulan') is-invalid @enderror"
                                                      id="kesimpulan" name="kesimpulan" rows="6"
                                                      required>{{ old('kesimpulan', $lpf->kesimpulan) }}</textarea>
                                            @error('kesimpulan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="usulan" class="form-label">Usulan</label>
                                            <textarea class="form-control @error('usulan') is-invalid @enderror"
                                                      id="usulan" name="usulan" rows="2"
                                                      required>{{ old('usulan', $lpf->usulan) }}</textarea>
                                            @error('usulan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="catatan_disposisi" class="form-label">Catatan / Disposisi Atasan (opsional)</label>
                                            <textarea class="form-control @error('catatan_disposisi') is-invalid @enderror"
                                                      id="catatan_disposisi" name="catatan_disposisi" rows="2">{{ old('catatan_disposisi', $lpf->catatan_disposisi) }}</textarea>
                                            @error('catatan_disposisi')
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
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-people me-2"></i>Penandatangan LPF</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="konseptor_id" class="form-label">Konseptor LPF</label>
                                            <select class="form-select @error('konseptor_id') is-invalid @enderror" id="konseptor_id" name="konseptor_id" required>
                                                @foreach($petugasData as $petugas)
                                                    <option value="{{ $petugas->id }}" {{ old('konseptor_id', $lpf->konseptor_id) == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('konseptor_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="pengampu_id" class="form-label">Mengetahui, Kepala Seksi Penindakan dan Penyidikan</label>
                                            <select class="form-select @error('pengampu_id') is-invalid @enderror" id="pengampu_id" name="pengampu_id" required>
                                                @foreach($petugasData as $petugas)
                                                    <option value="{{ $petugas->id }}" {{ old('pengampu_id', $lpf->pengampu_id) == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('pengampu_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="pemeriksa_id" class="form-label">Yang Membuat LPF, Pemeriksa Bea dan Cukai</label>
                                            <select class="form-select @error('pemeriksa_id') is-invalid @enderror" id="pemeriksa_id" name="pemeriksa_id" required>
                                                @foreach($petugasData as $petugas)
                                                    <option value="{{ $petugas->id }}" {{ old('pemeriksa_id', $lpf->pemeriksa_id) == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
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
                    <a href="{{ route('lpf.index') }}" class="btn btn-secondary">
                        <i class="cil-x-circle me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="cil-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
