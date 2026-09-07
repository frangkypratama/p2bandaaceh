@extends('layouts.app')

@section('content')
    @php $lphp = $lp->lphp; $sbp = optional($lphp)->sbp; @endphp
    <div class="container-lg">
        <form action="{{ route('lp.update', $lp->id) }}" method="POST" id="lpForm">
            @csrf
            @method('PUT')

            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="card-title mb-0 d-flex align-items-center">
                        <i class="cil-pencil me-2"></i>
                        <span><strong>Edit Laporan Pelanggaran {{ $lp->nomor_lp }}</strong></span>
                    </h4>
                    <small class="text-muted">Tindak lanjut atas LPHP {{ optional($lphp)->nomor_lphp }}.</small>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">

                        {{-- Data LPHP (read-only) --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-file me-2"></i>Data LPHP (Referensi)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nomor LPHP</label>
                                            <input type="text" class="form-control" value="{{ optional($lphp)->nomor_lphp }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Nomor SBP</label>
                                            <input type="text" class="form-control" value="{{ optional($sbp)->nomor_sbp }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Diduga Dilakukan Oleh</label>
                                            <input type="text" class="form-control" value="{{ optional($sbp)->nama_pelaku ?? '-' }} ({{ optional($sbp)->nomor_identitas ?? '-' }})" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Locus &amp; Tempus</label>
                                            <input type="text" class="form-control"
                                                   value="Kec. {{ optional($sbp)->kecamatan_penindakan ?? '-' }}, {{ optional($sbp)->kota_penindakan ?? '-' }} pukul {{ optional($sbp)->waktu_penindakan ?? '-' }}"
                                                   readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Detail LP --}}
                        <div class="col-md-12">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-notes me-2"></i>Detail Laporan Pelanggaran</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="tanggal_lp" class="form-label">Tanggal LP</label>
                                            <input type="date" class="form-control @error('tanggal_lp') is-invalid @enderror"
                                                   id="tanggal_lp" name="tanggal_lp" value="{{ old('tanggal_lp', $lp->tanggal_lp->format('Y-m-d')) }}" required>
                                            @error('tanggal_lp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="pejabat_penerbit_id" class="form-label">Pejabat Penerbit LP</label>
                                            <select class="form-select @error('pejabat_penerbit_id') is-invalid @enderror" id="pejabat_penerbit_id" name="pejabat_penerbit_id" required>
                                                @foreach($petugasData as $petugas)
                                                    <option value="{{ $petugas->id }}" {{ old('pejabat_penerbit_id', $lp->pejabat_penerbit_id) == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('pejabat_penerbit_id')
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
                        <i class="cil-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
