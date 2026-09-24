@extends('layouts.app')

@section('content')
    @php $lpf = $split->lpf; $lpp = optional($lpf)->lpp; $lp = optional($lpp)->lp; $lphp = optional($lp)->lphp; $sbp = optional($lphp)->sbp; @endphp
    <div class="container-lg">
        <form action="{{ route('split.update', $split->id) }}" method="POST" id="splitForm">
            @csrf
            @method('PUT')

            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="card-title mb-0 d-flex align-items-center">
                        <i class="cil-pencil me-2"></i>
                        <span><strong>Edit {{ $split->nomor_split }}</strong></span>
                    </h4>
                    <small class="text-muted">Tindak lanjut atas LPF {{ optional($lpf)->nomor_lpf }}.</small>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">

                        {{-- Data LPF (read-only) --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-file me-2"></i>Data LPF (Referensi)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nomor LPF</label>
                                            <input type="text" class="form-control" value="{{ optional($lpf)->nomor_lpf }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Nomor LP</label>
                                            <input type="text" class="form-control" value="{{ optional($lp)->nomor_lp }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Diduga Dilakukan Oleh</label>
                                            <input type="text" class="form-control" value="{{ optional($lphp)->pelaku_tidak_ditemukan ? 'Pelaku tidak ditemukan' : (optional($sbp)->nama_pelaku ?? '-') }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Detail SPLIT --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-notes me-2"></i>Detail Surat Perintah</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="tanggal_split" class="form-label">Tanggal Dikeluarkan</label>
                                            <input type="date" class="form-control @error('tanggal_split') is-invalid @enderror"
                                                   id="tanggal_split" name="tanggal_split" value="{{ old('tanggal_split', $split->tanggal_split->format('Y-m-d')) }}" required>
                                            @error('tanggal_split')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="dasar" class="form-label">Dasar</label>
                                            <textarea class="form-control @error('dasar') is-invalid @enderror"
                                                      id="dasar" name="dasar" rows="5"
                                                      required>{{ old('dasar', $split->dasar) }}</textarea>
                                            @error('dasar')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="pertimbangan" class="form-label">Pertimbangan</label>
                                            <textarea class="form-control @error('pertimbangan') is-invalid @enderror"
                                                      id="pertimbangan" name="pertimbangan" rows="3"
                                                      required>{{ old('pertimbangan', $split->pertimbangan) }}</textarea>
                                            @error('pertimbangan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="uraian_tugas" class="form-label">Untuk (Uraian Tugas)</label>
                                            <textarea class="form-control @error('uraian_tugas') is-invalid @enderror"
                                                      id="uraian_tugas" name="uraian_tugas" rows="3">{{ old('uraian_tugas', $split->uraian_tugas) }}</textarea>
                                            @error('uraian_tugas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Diperintahkan Kepada --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-people me-2"></i>Diperintahkan Kepada</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="petugas1_id" class="form-label">Petugas 1 (Penanggung Jawab)</label>
                                            <select class="form-select @error('petugas1_id') is-invalid @enderror" id="petugas1_id" name="petugas1_id" required>
                                                @foreach($petugasData as $petugas)
                                                    <option value="{{ $petugas->id }}" {{ old('petugas1_id', $split->petugas1_id) == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }} - {{ $petugas->jabatan }}</option>
                                                @endforeach
                                            </select>
                                            @error('petugas1_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="petugas2_id" class="form-label">Petugas 2 (Pelaksana)</label>
                                            <select class="form-select @error('petugas2_id') is-invalid @enderror" id="petugas2_id" name="petugas2_id" required>
                                                @foreach($petugasData as $petugas)
                                                    <option value="{{ $petugas->id }}" {{ old('petugas2_id', $split->petugas2_id) == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }} - {{ $petugas->jabatan }}</option>
                                                @endforeach
                                            </select>
                                            @error('petugas2_id')
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
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-user me-2"></i>Penerbit Surat Perintah</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="penerbit_id" class="form-label">Kepala Seksi Penindakan dan Penyidikan</label>
                                            <select class="form-select @error('penerbit_id') is-invalid @enderror" id="penerbit_id" name="penerbit_id" required>
                                                @foreach($petugasData as $petugas)
                                                    <option value="{{ $petugas->id }}" {{ old('penerbit_id', $split->penerbit_id) == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('penerbit_id')
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
                        <i class="cil-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
