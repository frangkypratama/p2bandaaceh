@extends('layouts.app')

@section('content')
<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0"><strong>Input Surat Bukti Pelanggaran (SBP)</strong></h4>
                    <small class="text-medium-emphasis">Lengkapi semua informasi yang diperlukan di bawah ini.</small>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('sbp.store') }}" class="row g-3">
                        @csrf

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
                                                    <input id="nomor_sbp" type="text" class="form-control" name="nomor_sbp" placeholder="Contoh: SBP-001" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tanggal_sbp" class="form-label">Tanggal SBP</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-calendar"></i></span>
                                                    <input id="tanggal_sbp" type="date" class="form-control" name="tanggal_sbp" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nomor_surat_perintah" class="form-label">Nomor Surat Perintah</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-file"></i></span>
                                                    <input id="nomor_surat_perintah" type="text" class="form-control" name="nomor_surat_perintah" placeholder="Contoh: SP-001" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tanggal_surat_perintah" class="form-label">Tanggal Surat Perintah</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-calendar"></i></span>
                                                    <input id="tanggal_surat_perintah" type="date" class="form-control" name="tanggal_surat_perintah" required>
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
                                            <input id="nama_pelaku" type="text" class="form-control" name="nama_pelaku" placeholder="Nama lengkap pelaku" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-credit-card"></i></span>
                                                    <select id="jenis_identitas" class="form-select" name="jenis_identitas" required>
                                                        <option selected disabled value="">Pilih Jenis Identitas...</option>
                                                        <option value="Paspor">Paspor</option>
                                                        <option value="KTP">KTP</option>
                                                        <option value="SIM">SIM</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nomor_identitas" class="form-label">Nomor Identitas</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-info"></i></span>
                                                    <input id="nomor_identitas" type="text" class="form-control" name="nomor_identitas" placeholder="Nomor identitas pelaku" required>
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
                                                    <input id="lokasi_penindakan" type="text" class="form-control" name="lokasi_penindakan" placeholder="Contoh: Terminal 2D Kedatangan" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="waktu_penindakan" class="form-label">Waktu Penindakan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-clock"></i></span>
                                                    <input id="waktu_penindakan" type="time" class="form-control" name="waktu_penindakan" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alasan_penindakan" class="form-label">Alasan Penindakan / Dugaan Pelanggaran</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-warning"></i></span>
                                            <textarea id="alasan_penindakan" class="form-control" name="alasan_penindakan" rows="3" placeholder="Jelaskan secara singkat alasan penindakan atau dugaan pelanggaran" required></textarea>
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="jenis_barang" class="form-label">Jenis Barang</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-layers"></i></span>
                                                    <input id="jenis_barang" type="text" class="form-control" name="jenis_barang" placeholder="Contoh: Minuman Keras" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-calculator"></i></span>
                                                    <input id="jumlah_barang" type="number" class="form-control" name="jumlah_barang" placeholder="0" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="uraian_barang" class="form-label">Uraian Barang</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-description"></i></span>
                                            <textarea id="uraian_barang" class="form-control" name="uraian_barang" rows="3" placeholder="Jelaskan secara detail mengenai barang bukti" required></textarea>
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
                                                    <input id="nama_petugas_1" type="text" class="form-control" name="nama_petugas_1" placeholder="Nama petugas pertama" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nama_petugas_2" class="form-label">Nama Petugas 2</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-user-follow"></i></span>
                                                    <input id="nama_petugas_2" type="text" class="form-control" name="nama_petugas_2" placeholder="Nama petugas kedua" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="cil-save"></i> Simpan Data SBP
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
