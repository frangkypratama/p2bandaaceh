@extends('layouts.app')

@section('content')
    @php
        $lp = $lpp->lp; $lphp = optional($lp)->lphp; $sbp = optional($lphp)->sbp;
    @endphp
    <div class="container-lg">
        <form action="{{ route('lpf.store') }}" method="POST" id="lpfForm">
            @csrf
            <input type="hidden" name="lpp_id" value="{{ $lpp->id }}">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0 d-flex align-items-center">
                        <i class="cil-plus me-2"></i>
                        <span><strong>Buat Lembar Penelitian Formal (LPF)</strong></span>
                    </h4>
                    <small class="text-medium-emphasis-white">Tindak lanjut atas LPP {{ $lpp->nomor_lpp }}.</small>
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
                                            <input type="text" class="form-control" value="{{ $lpp->nomor_lpp }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Nomor LP</label>
                                            <input type="text" class="form-control" value="{{ optional($lp)->nomor_lp }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Diduga Dilakukan Oleh</label>
                                            <input type="text" class="form-control" value="{{ optional($lphp)->pelaku_tidak_ditemukan ? 'Pelaku tidak ditemukan' : (optional($sbp)->nama_pelaku ?? '-') }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Lokasi &amp; Waktu</label>
                                            <input type="text" class="form-control"
                                                   value="{{ optional($sbp)->lokasi_penindakan ?? '-' }}, Kec. {{ optional($sbp)->kecamatan_penindakan ?? '-' }} - {{ optional(optional($sbp)->tanggal_sbp)->translatedFormat('d F Y') ?? '-' }} {{ optional($sbp)->waktu_penindakan ?? '' }} WIB"
                                                   readonly>
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
                                                   id="tanggal_lpf" name="tanggal_lpf" value="{{ old('tanggal_lpf', now()->format('Y-m-d')) }}" required>
                                            @error('tanggal_lpf')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="status_penangkapan" class="form-label">Status Penangkapan</label>
                                            <input type="text" class="form-control @error('status_penangkapan') is-invalid @enderror"
                                                   id="status_penangkapan" name="status_penangkapan" value="{{ old('status_penangkapan', 'Tertangkap tangan') }}" required>
                                            @error('status_penangkapan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label d-block mb-1"><strong>B. Kelengkapan Dokumen Penindakan</strong></label>
                                        </div>

                                        {{-- 1. No. Surat Perintah/Tugas - read only, ikut data SBP --}}
                                        <div class="col-md-6">
                                            <label class="form-label">1. No. Surat Perintah/Tugas</label>
                                            <input type="text" class="form-control" value="{{ optional($sbp)->nomor_surat_perintah ?? '-' }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal Surat Perintah/Tugas</label>
                                            <input type="text" class="form-control" value="{{ optional(optional($sbp)->tanggal_surat_perintah)->translatedFormat('d F Y') ?? '-' }}" readonly>
                                        </div>

                                        {{-- 2. No. Surat Limpahan --}}
                                        <div class="col-md-6">
                                            <label for="nomor_surat_limpahan" class="form-label">2. No. Surat Limpahan</label>
                                            <input type="text" class="form-control @error('nomor_surat_limpahan') is-invalid @enderror"
                                                   id="nomor_surat_limpahan" name="nomor_surat_limpahan" value="{{ old('nomor_surat_limpahan') }}">
                                            @error('nomor_surat_limpahan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tanggal_surat_limpahan" class="form-label">Tanggal Surat Limpahan</label>
                                            <input type="date" class="form-control @error('tanggal_surat_limpahan') is-invalid @enderror"
                                                   id="tanggal_surat_limpahan" name="tanggal_surat_limpahan" value="{{ old('tanggal_surat_limpahan') }}">
                                            @error('tanggal_surat_limpahan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- 3. No. LP - read only, ikut data LP --}}
                                        <div class="col-md-6">
                                            <label class="form-label">3. No. LP</label>
                                            <input type="text" class="form-control" value="{{ optional($lp)->nomor_lp ?? '-' }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal LP</label>
                                            <input type="text" class="form-control" value="{{ optional(optional($lp)->tanggal_lp)->translatedFormat('d F Y') ?? '-' }}" readonly>
                                        </div>

                                        {{-- 4. BAW Saksi --}}
                                        <div class="col-md-6">
                                            <label for="nomor_baw_saksi" class="form-label">4. BAW Saksi</label>
                                            <input type="text" class="form-control @error('nomor_baw_saksi') is-invalid @enderror"
                                                   id="nomor_baw_saksi" name="nomor_baw_saksi" value="{{ old('nomor_baw_saksi') }}">
                                            @error('nomor_baw_saksi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tanggal_baw_saksi" class="form-label">Tanggal BAW Saksi</label>
                                            <input type="date" class="form-control @error('tanggal_baw_saksi') is-invalid @enderror"
                                                   id="tanggal_baw_saksi" name="tanggal_baw_saksi" value="{{ old('tanggal_baw_saksi') }}">
                                            @error('tanggal_baw_saksi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- 5. BAP Tersangka --}}
                                        <div class="col-md-6">
                                            <label for="nomor_bap_tersangka" class="form-label">5. BAP Tersangka</label>
                                            <input type="text" class="form-control @error('nomor_bap_tersangka') is-invalid @enderror"
                                                   id="nomor_bap_tersangka" name="nomor_bap_tersangka" value="{{ old('nomor_bap_tersangka') }}">
                                            @error('nomor_bap_tersangka')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tanggal_bap_tersangka" class="form-label">Tanggal BAP Tersangka</label>
                                            <input type="date" class="form-control @error('tanggal_bap_tersangka') is-invalid @enderror"
                                                   id="tanggal_bap_tersangka" name="tanggal_bap_tersangka" value="{{ old('tanggal_bap_tersangka') }}">
                                            @error('tanggal_bap_tersangka')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- 6. Resume Perkara --}}
                                        <div class="col-md-6">
                                            <label for="nomor_resume_perkara" class="form-label">6. Resume Perkara</label>
                                            <input type="text" class="form-control @error('nomor_resume_perkara') is-invalid @enderror"
                                                   id="nomor_resume_perkara" name="nomor_resume_perkara" value="{{ old('nomor_resume_perkara') }}">
                                            @error('nomor_resume_perkara')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tanggal_resume_perkara" class="form-label">Tanggal Resume Perkara</label>
                                            <input type="date" class="form-control @error('tanggal_resume_perkara') is-invalid @enderror"
                                                   id="tanggal_resume_perkara" name="tanggal_resume_perkara" value="{{ old('tanggal_resume_perkara') }}">
                                            @error('tanggal_resume_perkara')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- 7. Dokumen Lain --}}
                                        <div class="col-md-6">
                                            <label for="nomor_dokumen_lain" class="form-label">7. Dokumen Lain</label>
                                            <input type="text" class="form-control @error('nomor_dokumen_lain') is-invalid @enderror"
                                                   id="nomor_dokumen_lain" name="nomor_dokumen_lain" value="{{ old('nomor_dokumen_lain') }}">
                                            @error('nomor_dokumen_lain')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tanggal_dokumen_lain" class="form-label">Tanggal Dokumen Lain</label>
                                            <input type="date" class="form-control @error('tanggal_dokumen_lain') is-invalid @enderror"
                                                   id="tanggal_dokumen_lain" name="tanggal_dokumen_lain" value="{{ old('tanggal_dokumen_lain') }}">
                                            @error('tanggal_dokumen_lain')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="barang_hasil_penindakan" class="form-label">Barang Hasil Penindakan (opsional)</label>
                                            <textarea class="form-control @error('barang_hasil_penindakan') is-invalid @enderror"
                                                      id="barang_hasil_penindakan" name="barang_hasil_penindakan" rows="3"
                                                      placeholder="Merek, kondisi, tipe, spesifikasi, jumlah/jenis koli, dokumen pabean asal, sarana pengangkut, dsb.">{{ old('barang_hasil_penindakan', optional($sbp)->uraian_barang) }}</textarea>
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
                                                      required>{{ old('domain_perkara', $defaultDomainPerkara) }}</textarea>
                                            @error('domain_perkara')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label d-block mb-1"><strong>D. Kesimpulan</strong></label>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lengkap_berkas" class="form-label">Lengkap tidaknya berkas penindakan</label>
                                            <select class="form-select @error('lengkap_berkas') is-invalid @enderror" id="lengkap_berkas" name="lengkap_berkas" required>
                                                @foreach($opsiCukup as $opsi)
                                                    <option value="{{ $opsi }}" {{ old('lengkap_berkas', 'Cukup') == $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                                                @endforeach
                                            </select>
                                            @error('lengkap_berkas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="cukup_barang_bukti" class="form-label">Cukup tidaknya barang bukti</label>
                                            <select class="form-select @error('cukup_barang_bukti') is-invalid @enderror" id="cukup_barang_bukti" name="cukup_barang_bukti" required>
                                                @foreach($opsiCukup as $opsi)
                                                    <option value="{{ $opsi }}" {{ old('cukup_barang_bukti', 'Cukup') == $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                                                @endforeach
                                            </select>
                                            @error('cukup_barang_bukti')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="cukup_alat_bukti" class="form-label">Cukup tidaknya alat bukti</label>
                                            <select class="form-select @error('cukup_alat_bukti') is-invalid @enderror" id="cukup_alat_bukti" name="cukup_alat_bukti" required>
                                                @foreach($opsiCukup as $opsi)
                                                    <option value="{{ $opsi }}" {{ old('cukup_alat_bukti', 'Cukup') == $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                                                @endforeach
                                            </select>
                                            @error('cukup_alat_bukti')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="keberadaan_pelaku" class="form-label">Keberadaan pelaku</label>
                                            <select class="form-select @error('keberadaan_pelaku') is-invalid @enderror" id="keberadaan_pelaku" name="keberadaan_pelaku" required>
                                                @foreach($opsiAda as $opsi)
                                                    <option value="{{ $opsi }}" {{ old('keberadaan_pelaku', 'Ada') == $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                                                @endforeach
                                            </select>
                                            @error('keberadaan_pelaku')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="keterkaitan_bukti_pelaku" class="form-label">Keterkaitan alat bukti, barang bukti dan pelaku</label>
                                            <select class="form-select @error('keterkaitan_bukti_pelaku') is-invalid @enderror" id="keterkaitan_bukti_pelaku" name="keterkaitan_bukti_pelaku" required>
                                                @foreach($opsiAda as $opsi)
                                                    <option value="{{ $opsi }}" {{ old('keterkaitan_bukti_pelaku', 'Ada') == $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                                                @endforeach
                                            </select>
                                            @error('keterkaitan_bukti_pelaku')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="indikasi_pelanggaran" class="form-label">Ada tidaknya indikasi pelanggaran</label>
                                            <select class="form-select @error('indikasi_pelanggaran') is-invalid @enderror" id="indikasi_pelanggaran" name="indikasi_pelanggaran" required>
                                                @foreach($opsiAda as $opsi)
                                                    <option value="{{ $opsi }}" {{ old('indikasi_pelanggaran', 'Ada') == $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                                                @endforeach
                                            </select>
                                            @error('indikasi_pelanggaran')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="usulan" class="form-label">Usulan</label>
                                            <textarea class="form-control @error('usulan') is-invalid @enderror"
                                                      id="usulan" name="usulan" rows="2"
                                                      required>{{ old('usulan', 'Dilakukan penelitian lebih lanjut untuk dapat menentukan penyelesaian perkara dimaksud.') }}</textarea>
                                            @error('usulan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="catatan_disposisi" class="form-label">Catatan / Disposisi Atasan (opsional)</label>
                                            <textarea class="form-control @error('catatan_disposisi') is-invalid @enderror"
                                                      id="catatan_disposisi" name="catatan_disposisi" rows="2">{{ old('catatan_disposisi') }}</textarea>
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
                                            <label for="pemeriksa_id" class="form-label">Yang Membuat LPF, Pemeriksa Bea dan Cukai</label>
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
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-end bg-light">
                    <a href="{{ route('lpp.index') }}" class="btn btn-secondary">
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
