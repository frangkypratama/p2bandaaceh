@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <strong>Edit Laporan Pelaksanaan Tugas (LPT)</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('lpt.update', $lpt->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="nomor_lpt" class="form-label">Nomor LPT</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="cil-notes"></i></span>
                                    <input type="text" class="form-control @error('nomor_lpt') is-invalid @enderror" id="nomor_lpt" name="nomor_lpt" value="{{ old('nomor_lpt', $lpt->nomor_lpt) }}" required>
                                </div>
                                @error('nomor_lpt')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

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

                            <div class="form-group mb-3">
                                <label for="jenis_lpt" class="form-label">Jenis LPT</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="cil-tag"></i></span>
                                    <input type="text" class="form-control @error('jenis_lpt') is-invalid @enderror" id="jenis_lpt" name="jenis_lpt" value="{{ old('jenis_lpt', $lpt->jenis_lpt) }}" required>
                                </div>
                                @error('jenis_lpt')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="cil-save me-2"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('lpt.index') }}" class="btn btn-secondary">
                                    <i class="cil-x-circle me-2"></i>Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
