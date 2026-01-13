@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>Input SBP</strong></div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('sbp.store') }}">
                        @csrf

                        <h5>Penomoran</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="nomor_sbp" class="col-md-4 col-form-label text-md-end">Nomor SBP</label>
                                    <div class="col-md-8">
                                        <input id="nomor_sbp" type="text" class="form-control" name="nomor_sbp" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="tanggal_sbp" class="col-md-4 col-form-label text-md-end">Tanggal SBP</label>
                                    <div class="col-md-8">
                                        <input id="tanggal_sbp" type="date" class="form-control" name="tanggal_sbp" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="nomor_surat_perintah" class="col-md-4 col-form-label text-md-end">Nomor Surat Perintah</label>
                                    <div class="col-md-8">
                                        <input id="nomor_surat_perintah" type="text" class="form-control" name="nomor_surat_perintah" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="tanggal_surat_perintah" class="col-md-4 col-form-label text-md-end">Tanggal Surat Perintah</label>
                                    <div class="col-md-8">
                                        <input id="tanggal_surat_perintah" type="date" class="form-control" name="tanggal_surat_perintah" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5>Data Identitas</h5>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="row">
                                    <label for="nama_pelaku" class="col-md-2 col-form-label text-md-end">Nama Pelaku</label>
                                    <div class="col-md-10">
                                        <input id="nama_pelaku" type="text" class="form-control" name="nama_pelaku" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="jenis_identitas" class="col-md-4 col-form-label text-md-end">Jenis Identitas</label>
                                    <div class="col-md-8">
                                        <select id="jenis_identitas" class="form-control" name="jenis_identitas" required>
                                            <option value="Paspor">Paspor</option>
                                            <option value="KTP">KTP</option>
                                            <option value="SIM">SIM</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="nomor_identitas" class="col-md-4 col-form-label text-md-end">Nomor Identitas</label>
                                    <div class="col-md-8">
                                        <input id="nomor_identitas" type="text" class="form-control" name="nomor_identitas" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr>

                        <h5>Lokasi & Waktu Penindakan</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="lokasi_penindakan" class="col-md-4 col-form-label text-md-end">Lokasi Penindakan</label>
                                    <div class="col-md-8">
                                        <input id="lokasi_penindakan" type="text" class="form-control" name="lokasi_penindakan" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="waktu_penindakan" class="col-md-4 col-form-label text-md-end">Waktu Penindakan</label>
                                    <div class="col-md-8">
                                        <input id="waktu_penindakan" type="time" class="form-control" name="waktu_penindakan" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5>Dugaan Pelanggaran</h5>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="row">
                                    <label for="alasan_penindakan" class="col-md-2 col-form-label text-md-end">Alasan Penindakan</label>
                                    <div class="col-md-10">
                                        <textarea id="alasan_penindakan" class="form-control" name="alasan_penindakan" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5>Data Barang</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="jenis_barang" class="col-md-4 col-form-label text-md-end">Jenis Barang</label>
                                    <div class="col-md-8">
                                        <input id="jenis_barang" type="text" class="form-control" name="jenis_barang" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="jumlah_barang" class="col-md-4 col-form-label text-md-end">Jumlah Barang</label>
                                    <div class="col-md-8">
                                        <input id="jumlah_barang" type="number" class="form-control" name="jumlah_barang" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="row">
                                    <label for="uraian_barang" class="col-md-2 col-form-label text-md-end">Uraian Barang</label>
                                    <div class="col-md-10">
                                        <textarea id="uraian_barang" class="form-control" name="uraian_barang" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5>Petugas</h5>
                         <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="nama_petugas_1" class="col-md-4 col-form-label text-md-end">Nama Petugas 1</label>
                                    <div class="col-md-8">
                                        <input id="nama_petugas_1" type="text" class="form-control" name="nama_petugas_1" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="nama_petugas_2" class="col-md-4 col-form-label text-md-end">Nama Petugas 2</label>
                                    <div class="col-md-8">
                                        <input id="nama_petugas_2" type="text" class="form-control" name="nama_petugas_2" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
