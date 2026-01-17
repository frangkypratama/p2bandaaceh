@extends('layouts.app')

@section('content')
<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0"><strong>Edit Surat Bukti Penindakan (SBP)</strong></h4>
                    <small class="text-medium-emphasis">Perbarui informasi yang diperlukan di bawah ini.</small>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @error('nomor_sbp_formatted')
                        <div class="alert alert-danger" role="alert">
                            Data sudah ada
                        </div>
                    @enderror

                    <form method="POST" action="{{ route('sbp.update', $sbp->id) }}" class="row g-3">
                        @csrf
                        @method('PUT')

                        {{-- Penomoran --}}
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">1. Penomoran & Referensi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nomor_sbp" class="form-label">Nomor SBP</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-notes"></i></span>
                                                    <input id="nomor_sbp" type="number" class="form-control" name="nomor_sbp" value="{{ $sbp->nomor_sbp_int }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tanggal_sbp" class="form-label">Tanggal SBP</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-calendar"></i></span>
                                                    <input id="tanggal_sbp" type="date" class="form-control" name="tanggal_sbp" value="{{ $sbp->tanggal_sbp }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nomor_surat_perintah" class="form-label">Nomor Surat Perintah</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-file"></i></span>
                                                    <input id="nomor_surat_perintah" type="text" class="form-control" name="nomor_surat_perintah" value="{{ $sbp->nomor_surat_perintah }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tanggal_surat_perintah" class="form-label">Tanggal Surat Perintah</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-calendar"></i></span>
                                                    <input id="tanggal_surat_perintah" type="date" class="form-control" name="tanggal_surat_perintah" value="{{ $sbp->tanggal_surat_perintah }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Data Identitas --}}
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">2. Data Identitas Pelaku</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="nama_pelaku" class="form-label">Nama Pelaku</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-user"></i></span>
                                            <input id="nama_pelaku" type="text" class="form-control" name="nama_pelaku" value="{{ $sbp->nama_pelaku }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-credit-card"></i></span>
                                                    <select id="jenis_identitas" class="form-select" name="jenis_identitas" required>
                                                        <option value="Paspor" {{ $sbp->jenis_identitas == 'Paspor' ? 'selected' : '' }}>Paspor</option>
                                                        <option value="KTP" {{ $sbp->jenis_identitas == 'KTP' ? 'selected' : '' }}>KTP</option>
                                                        <option value="SIM" {{ $sbp->jenis_identitas == 'SIM' ? 'selected' : '' }}>SIM</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nomor_identitas" class="form-label">Nomor Identitas</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-info"></i></span>
                                                    <input id="nomor_identitas" type="text" class="form-control" name="nomor_identitas" value="{{ $sbp->nomor_identitas }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Detail Penindakan --}}
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">3. Detail Penindakan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="lokasi_penindakan" class="form-label">Lokasi Penindakan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-location-pin"></i></span>
                                                    <input id="lokasi_penindakan" type="text" class="form-control" name="lokasi_penindakan" value="{{ $sbp->lokasi_penindakan }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="waktu_penindakan" class="form-label">Waktu Penindakan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-clock"></i></span>
                                                    <input id="waktu_penindakan" type="time" class="form-control" name="waktu_penindakan" value="{{ $sbp->waktu_penindakan }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alasan_penindakan" class="form-label">Alasan Penindakan</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-warning"></i></span>
                                            <textarea id="alasan_penindakan" class="form-control" name="alasan_penindakan" rows="3" required>{{ $sbp->alasan_penindakan }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Informasi Barang Bukti --}}
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">4. Informasi Barang Bukti</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="jenis_barang" class="form-label">Jenis Barang</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-layers"></i></span>
                                            <input id="jenis_barang" type="text" class="form-control" name="jenis_barang" value="{{ $sbp->jenis_barang }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-calculator"></i></span>
                                                    <input id="jumlah_barang" type="number" class="form-control" name="jumlah_barang" value="{{ $sbp->jumlah_barang }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="jenis_satuan" class="form-label">Jenis Satuan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-puzzle"></i></span>
                                                    <select id="jenis_satuan" class="form-select" name="jenis_satuan" required>
                                                        <option value="Pcs" {{ $sbp->jenis_satuan == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                                        <option value="Pkg" {{ $sbp->jenis_satuan == 'Pkg' ? 'selected' : '' }}>Package</option>
                                                        <option value="Unit" {{ $sbp->jenis_satuan == 'Unit' ? 'selected' : '' }}>Unit</option>
                                                        <option value="Batang" {{ $sbp->jenis_satuan == 'Batang' ? 'selected' : '' }}>Batang</option>
                                                        <option value="Botol" {{ $sbp->jenis_satuan == 'Botol' ? 'selected' : '' }}>Botol</option>
                                                        <option value="Gram" {{ $sbp->jenis_satuan == 'Gram' ? 'selected' : '' }}>Gram</option>
                                                        <option value="Kilogram" {{ $sbp->jenis_satuan == 'Kilogram' ? 'selected' : '' }}>Kilogram</option>
                                                        <option value="Buah" {{ $sbp->jenis_satuan == 'Buah' ? 'selected' : '' }}>Buah</option>
                                                        <option value="Bungkus" {{ $sbp->jenis_satuan == 'Bungkus' ? 'selected' : '' }}>Bungkus</option>
                                                        <option value="Kotak" {{ $sbp->jenis_satuan == 'Kotak' ? 'selected' : '' }}>Kotak</option>
                                                        <option value="Liter" {{ $sbp->jenis_satuan == 'Liter' ? 'selected' : '' }}>Liter</option>
                                                        <option value="Mililiter" {{ $sbp->jenis_satuan == 'Mililiter' ? 'selected' : '' }}>Mililiter</option>
                                                        <option value="Karton" {{ $sbp->jenis_satuan == 'Karton' ? 'selected' : '' }}>Karton</option>
                                                        <option value="Set" {{ $sbp->jenis_satuan == 'Set' ? 'selected' : '' }}>Set</option>
                                                        <option value="Pasang" {{ $sbp->jenis_satuan == 'Pasang' ? 'selected' : '' }}>Pasang</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="uraian_barang" class="form-label">Uraian Barang</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-description"></i></span>
                                            <textarea id="uraian_barang" class="form-control" name="uraian_barang" rows="3" required>{{ $sbp->uraian_barang }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Petugas --}}
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">5. Petugas yang Bertugas</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nama_petugas_1" class="form-label">Nama Petugas 1</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-user-follow"></i></span>
                                                    <select id="nama_petugas_1" class="form-select" name="nama_petugas_1" required>
                                                        @foreach($petugasData as $petugas)
                                                            <option value="{{ $petugas->nama }}" {{ $sbp->nama_petugas_1 == $petugas->nama ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nama_petugas_2" class="form-label">Nama Petugas 2</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-user-follow"></i></span>
                                                    <select id="nama_petugas_2" class="form-select" name="nama_petugas_2" required>
                                                        @foreach($petugasData as $petugas)
                                                            <option value="{{ $petugas->nama }}" {{ $sbp->nama_petugas_2 == $petugas->nama ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-center">
                            <a href="{{ route('sbp.index') }}" class="btn btn-secondary btn-lg">
                                <i class="cil-arrow-circle-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg ms-2">
                                <i class="cil-sync"></i> Perbarui Data SBP
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
