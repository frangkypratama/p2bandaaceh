@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <strong>Edit Laporan Pelaksanaan Tugas (LPT)</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('lpt.update', $lpt->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Jenis LPT --}}
                            <div class="form-group mb-3">
                                <label for="jenis_lpt" class="form-label">Jenis LPT</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="cil-tag"></i></span>
                                    <select class="form-select @error('jenis_lpt') is-invalid @enderror" id="jenis_lpt" name="jenis_lpt" required>
                                        @foreach($jenis_lpt_options as $pilihan_jenis_lpt => $options)
                                            <option value="{{ $pilihan_jenis_lpt }}" {{ old('jenis_lpt', $lpt->jenis_lpt) == $pilihan_jenis_lpt ? 'selected' : '' }}>{{ $options['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('jenis_lpt')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Penomoran LPT --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nomor_lpt_int" class="form-label">Nomor LPT</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-notes"></i></span>
                                            <input type="number" class="form-control @error('nomor_lpt_int') is-invalid @enderror" id="nomor_lpt_int" name="nomor_lpt_int" value="{{ old('nomor_lpt_int', $lpt->nomor_lpt_int) }}" placeholder="Hanya isi dengan angka" required>
                                        </div>
                                        @error('nomor_lpt_int')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="tanggal_lpt" class="form-label">Tanggal LPT</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-calendar"></i></span>
                                            <input type="date" class="form-control @error('tanggal_lpt') is-invalid @enderror" id="tanggal_lpt" name="tanggal_lpt" value="{{ old('tanggal_lpt', $lpt->tanggal_lpt) }}" required>
                                        </div>
                                        @error('tanggal_lpt')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- SBP Selection --}}
                            <div class="form-group mb-3">
                                <label for="nomor_sbp_display" class="form-label">Nomor SBP</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('sbp_id') is-invalid @enderror" id="nomor_sbp_display" placeholder="Pilih SBP..." readonly value="{{ $lpt->sbp->nomor_sbp ?? '' }}">
                                    <button class="btn btn-outline-primary" type="button" id="pilihSbpBtn">Pilih SBP</button>
                                </div>
                                <input type="hidden" name="sbp_id" id="sbp_id" value="{{ $lpt->sbp_id }}">
                                @error('sbp_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Existing Photos --}}
                            <div class="form-group mb-3">
                                <label class="form-label">Dokumentasi Foto Saat Ini</label>
                                <div class="row">
                                    @forelse($lpt->photos as $photo)
                                        <div class="col-md-3 mb-3" id="photo-{{ $photo->id }}">
                                            <div class="card">
                                                <img src="{{ asset('storage/' . $photo->file_path) }}" class="card-img-top" alt="Foto LPT">
                                                <div class="card-body text-center">
                                                    <button type="button" class="btn btn-sm btn-danger delete-photo-btn" data-id="{{ $photo->id }}">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <p class="text-muted">Tidak ada foto yang terlampir.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            {{-- Photo Upload --}}
                            <div class="form-group mb-3">
                                <label for="photos" class="form-label">Upload Foto Baru</label>
                                <div class="input-group">
                                    <input type="file" class="form-control @error('photos.*') is-invalid @enderror" id="photos" name="photos[]" multiple>
                                </div>
                                <small class="form-text text-muted">Anda dapat memilih lebih dari satu foto. Foto baru akan ditambahkan ke foto yang sudah ada.</small>
                                @error('photos.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="cil-save me-2"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('lpt.index') }}" class="btn btn-secondary">
                                    <i class="cil-x-circle me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
