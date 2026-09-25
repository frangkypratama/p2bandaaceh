@extends('layouts.app')

@section('content')
    @php
        $lpf = $split->lpf; $lpp = optional($lpf)->lpp; $lp = optional($lpp)->lp; $lphp = optional($lp)->lphp;
    @endphp
    <div class="container-lg">
        <form action="{{ route('lhp.store') }}" method="POST" id="lhpForm">
            @csrf
            <input type="hidden" name="split_id" value="{{ $split->id }}">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0 d-flex align-items-center">
                        <i class="cil-plus me-2"></i>
                        <span><strong>Buat Lembar Hasil Penelitian (LHP)</strong></span>
                    </h4>
                    <small class="text-medium-emphasis-white">Tindak lanjut atas SPLIT {{ $split->nomor_split }}.</small>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">

                        {{-- Data Referensi --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-file me-2"></i>Data Referensi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nomor LP</label>
                                            <input type="text" class="form-control" value="{{ optional($lp)->nomor_lp }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Nomor SPLIT</label>
                                            <input type="text" class="form-control" value="{{ $split->nomor_split }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Diduga Dilakukan Oleh</label>
                                            <input type="text" class="form-control" value="{{ optional($lphp)->pelaku_tidak_ditemukan ? 'Pelaku tidak ditemukan' : (optional($sbp)->nama_pelaku ?? '-') }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">NIK / No. Paspor</label>
                                            <input type="text" class="form-control" value="{{ optional($sbp)->nomor_identitas ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- A. Uraian Pelanggaran --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-notes me-2"></i>A. Uraian Pelanggaran</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="tanggal_lhp" class="form-label">Tanggal LHP</label>
                                            <input type="date" class="form-control @error('tanggal_lhp') is-invalid @enderror"
                                                   id="tanggal_lhp" name="tanggal_lhp" value="{{ old('tanggal_lhp', optional($defaultTanggalLhp)->format('Y-m-d')) }}" required>
                                            @error('tanggal_lhp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="jenis_pelanggaran" class="form-label">Jenis Pelanggaran</label>
                                            <select class="form-select @error('jenis_pelanggaran') is-invalid @enderror" id="jenis_pelanggaran" name="jenis_pelanggaran" required>
                                                <option value="Kepabeanan" {{ old('jenis_pelanggaran', $defaultJenisPelanggaran) == 'Kepabeanan' ? 'selected' : '' }}>Kepabeanan</option>
                                                <option value="Cukai" {{ old('jenis_pelanggaran', $defaultJenisPelanggaran) == 'Cukai' ? 'selected' : '' }}>Cukai</option>
                                            </select>
                                            @error('jenis_pelanggaran')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="pelaku_administrasi" class="form-label">Pelaku Pelanggaran Administrasi (opsional)</label>
                                            <textarea class="form-control @error('pelaku_administrasi') is-invalid @enderror"
                                                      id="pelaku_administrasi" name="pelaku_administrasi" rows="3"
                                                      placeholder="NPWP, Nomor Telepon, Nomor Rekening, Pengulangan Pelanggaran, dsb.">{{ old('pelaku_administrasi') }}</textarea>
                                            @error('pelaku_administrasi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="saksi_saksi" class="form-label">Saksi-Saksi / Pelaku Tidak Dikenal (opsional)</label>
                                            <textarea class="form-control @error('saksi_saksi') is-invalid @enderror"
                                                      id="saksi_saksi" name="saksi_saksi" rows="3">{{ old('saksi_saksi') }}</textarea>
                                            @error('saksi_saksi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="uraian_barang_tambahan" class="form-label">Uraian Barang Tambahan (opsional)</label>
                                            <textarea class="form-control @error('uraian_barang_tambahan') is-invalid @enderror"
                                                      id="uraian_barang_tambahan" name="uraian_barang_tambahan" rows="2"
                                                      placeholder="Merk/type, kondisi, kemasan, dsb.">{{ old('uraian_barang_tambahan') }}</textarea>
                                            @error('uraian_barang_tambahan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="sarana_pengangkut" class="form-label">Sarana Pengangkut (opsional)</label>
                                            <textarea class="form-control @error('sarana_pengangkut') is-invalid @enderror"
                                                      id="sarana_pengangkut" name="sarana_pengangkut" rows="2"
                                                      placeholder="Jenis sarana, No. Polisi/Voyage, Bukti Kepemilikan, No. Kontainer, Surat Jalan, dsb.">{{ old('sarana_pengangkut') }}</textarea>
                                            @error('sarana_pengangkut')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="dokumen_dokumen" class="form-label">Dokumen-Dokumen (opsional)</label>
                                            <textarea class="form-control @error('dokumen_dokumen') is-invalid @enderror"
                                                      id="dokumen_dokumen" name="dokumen_dokumen" rows="2"
                                                      placeholder="Dokumen Pabean/Cukai, Dokumen Pelengkap, Kantor Pendaftaran, dsb.">{{ old('dokumen_dokumen') }}</textarea>
                                            @error('dokumen_dokumen')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- B-G --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-check-circle me-2"></i>B-G. Modus, Unsur Pasal &amp; Kesimpulan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label for="modus_pelanggaran" class="form-label">B. Modus Pelanggaran</label>
                                            <textarea class="form-control @error('modus_pelanggaran') is-invalid @enderror"
                                                      id="modus_pelanggaran" name="modus_pelanggaran" rows="2"
                                                      required>{{ old('modus_pelanggaran', optional($sbp)->alasan_penindakan) }}</textarea>
                                            @error('modus_pelanggaran')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="pemenuhan_unsur_pasal" class="form-label">C. Pemenuhan Unsur Pasal</label>
                                            <textarea class="form-control @error('pemenuhan_unsur_pasal') is-invalid @enderror"
                                                      id="pemenuhan_unsur_pasal" name="pemenuhan_unsur_pasal" rows="3"
                                                      required>{{ old('pemenuhan_unsur_pasal', 'Berdasarkan keterangan dan bukti-bukti tersebut ' . (optional($lphp)->pelaku_tidak_ditemukan ? 'pelaku yang tidak ditemukan' : (optional($sbp)->nama_pelaku ?? 'pelaku')) . ' diduga melanggar ' . (optional($lphp)->pasal ?? '-') . ' ' . (optional($lphp)->uu_terkait ?? '')) }}</textarea>
                                            @error('pemenuhan_unsur_pasal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="kesimpulan" class="form-label">D. Kesimpulan</label>
                                            <textarea class="form-control @error('kesimpulan') is-invalid @enderror"
                                                      id="kesimpulan" name="kesimpulan" rows="3"
                                                      required>{{ old('kesimpulan') }}</textarea>
                                            @error('kesimpulan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="alternatif_penyelesaian" class="form-label">E. Alternatif Penyelesaian Perkara (opsional)</label>
                                            <textarea class="form-control @error('alternatif_penyelesaian') is-invalid @enderror"
                                                      id="alternatif_penyelesaian" name="alternatif_penyelesaian" rows="2">{{ old('alternatif_penyelesaian') }}</textarea>
                                            @error('alternatif_penyelesaian')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="informasi_lainnya" class="form-label">F. Informasi Lainnya (opsional)</label>
                                            <textarea class="form-control @error('informasi_lainnya') is-invalid @enderror"
                                                      id="informasi_lainnya" name="informasi_lainnya" rows="2">{{ old('informasi_lainnya') }}</textarea>
                                            @error('informasi_lainnya')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="catatan_atasan" class="form-label">G. Catatan Atasan (opsional)</label>
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
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-people me-2"></i>Penandatangan LHP</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="konseptor_id" class="form-label">Konseptor LHP</label>
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
                                            <label for="pemeriksa_id" class="form-label">Yang Membuat LHP, Pemeriksa Bea dan Cukai</label>
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
                    <a href="{{ route('split.index') }}" class="btn btn-secondary">
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
