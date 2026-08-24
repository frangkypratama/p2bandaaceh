@extends('layouts.app')

@section('title', 'Input Pemeriksaan Badan')

@section('content')
<div class="container-lg">
    <form method="POST" action="{{ route('pemeriksaan-badan.store') }}" id="createPemeriksaanForm">
        @csrf

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0 d-flex align-items-center">
                    <i class="cil-plus me-2"></i>
                    <span><strong>Input Pemeriksaan Badan</strong></span>
                </h4>
                <small class="text-medium-emphasis-white">Lengkapi semua informasi yang diperlukan di bawah ini.</small>
            </div>

            <div class="card-body p-4">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Terdapat Kesalahan!</h4>
                        <p>Mohon periksa kembali data yang Anda masukkan. Beberapa isian tidak valid.</p>
                        <hr>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row g-4">
                    {{-- Penomoran & Referensi --}}
                    <div class="col-md-12">
                        <div class="card h-100 border-light shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-notes me-2"></i>Penomoran & Referensi</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="no_ba_riksa_nomor" class="form-label">Nomor BA Riksa Badan</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-notes"></i></span>
                                            <input type="text" class="form-control @error('no_ba_riksa') is-invalid @enderror" id="no_ba_riksa_nomor" placeholder="Masukkan hanya angka" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            <button class="btn btn-outline-secondary" type="button" id="fetch-last-number" title="Ambil Nomor Terakhir">
                                                <i class="cil-loop-circular"></i>
                                            </button>
                                            @error('no_ba_riksa')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <input type="hidden" name="no_ba_riksa" id="no_ba_riksa">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tgl_ba_riksa" class="form-label">Tanggal BA Riksa Badan</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-calendar"></i></span>
                                            <input type="date" class="form-control @error('tgl_ba_riksa') is-invalid @enderror" id="tgl_ba_riksa" name="tgl_ba_riksa" value="{{ old('tgl_ba_riksa') }}" required>
                                            @error('tgl_ba_riksa')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="no_surat_perintah" class="form-label">Nomor Surat Perintah</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-file"></i></span>
                                            <input class="form-control @error('no_surat_perintah') is-invalid @enderror" list="datalistOptions" id="no_surat_perintah" name="no_surat_perintah" placeholder="Ketik untuk mencari..." value="{{ old('no_surat_perintah', 'PRIN-') }}" required>
                                            <datalist id="datalistOptions">
                                                @foreach($suratPerintahData as $sp)
                                                    <option value="{{ $sp->nomor_prin }}">
                                                @endforeach
                                            </datalist>
                                            @error('no_surat_perintah')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tgl_surat_perintah" class="form-label">Tanggal Surat Perintah</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-calendar"></i></span>
                                            <input type="date" class="form-control @error('tgl_surat_perintah') is-invalid @enderror" id="tgl_surat_perintah" name="tgl_surat_perintah" value="{{ old('tgl_surat_perintah') }}" readonly>
                                            @error('tgl_surat_perintah')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Data Pelaku --}}
                    <div class="col-md-12">
                        <div class="card h-100 border-light shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-user me-2"></i>Data Pelaku</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-user"></i></span>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
                                            @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-credit-card"></i></span>
                                            <select class="form-select @error('jenis_identitas') is-invalid @enderror" id="jenis_identitas" name="jenis_identitas">
                                                <option value="" disabled selected>Pilih...</option>
                                                <option value="Paspor" {{ old('jenis_identitas') == 'Paspor' ? 'selected' : '' }}>Paspor</option>
                                                <option value="KTP" {{ old('jenis_identitas') == 'KTP' ? 'selected' : '' }}>KTP</option>
                                                <option value="KITAS" {{ old('jenis_identitas') == 'KITAS' ? 'selected' : '' }}>KITAS</option>
                                                <option value="Kartu Keluarga" {{ old('jenis_identitas') == 'Kartu Keluarga' ? 'selected' : '' }}>Kartu Keluarga</option>
                                            </select>
                                            @error('jenis_identitas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="no_identitas" class="form-label">Nomor Identitas</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-info"></i></span>
                                            <input type="text" class="form-control @error('no_identitas') is-invalid @enderror" id="no_identitas" name="no_identitas" value="{{ old('no_identitas') }}">
                                            @error('no_identitas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-location-pin"></i></span>
                                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                            @error('tempat_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-calendar"></i></span>
                                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                            @error('tanggal_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-wc"></i></span>
                                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin">
                                                <option value="" disabled selected>Pilih...</option>
                                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                            @error('jenis_kelamin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-globe-alt"></i></span>
                                            <select class="form-select @error('kewarganegaraan') is-invalid @enderror" id="kewarganegaraan" name="kewarganegaraan">
                                                <option value="" disabled selected>Pilih Kewarganegaraan...</option>
                                                @foreach ($nationalities as $nationality)
                                                    <option value="{{ $nationality }}" {{ old('kewarganegaraan') == $nationality ? 'selected' : '' }}>
                                                        {{ $nationality }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('kewarganegaraan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="alamat_pada_identitas" class="form-label">Alamat Sesuai Identitas</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-map"></i></span>
                                            <textarea class="form-control @error('alamat_pada_identitas') is-invalid @enderror" id="alamat_pada_identitas" name="alamat_pada_identitas" rows="2">{{ old('alamat_pada_identitas') }}</textarea>
                                            @error('alamat_pada_identitas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="alamat_tinggal" class="form-label">Alamat Tempat Tinggal Saat Ini</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-home"></i></span>
                                            <textarea class="form-control @error('alamat_tinggal') is-invalid @enderror" id="alamat_tinggal" name="alamat_tinggal" rows="2">{{ old('alamat_tinggal') }}</textarea>
                                            @error('alamat_tinggal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="datang_dari" class="form-label">Datang Dari</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-flight-takeoff"></i></span>
                                            <input type="text" class="form-control @error('datang_dari') is-invalid @enderror" id="datang_dari" name="datang_dari" value="{{ old('datang_dari') }}">
                                            @error('datang_dari')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tujuan_ke" class="form-label">Tujuan Ke</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-location-pin"></i></span>
                                            <input type="text" class="form-control @error('tujuan_ke') is-invalid @enderror" id="tujuan_ke" name="tujuan_ke" value="{{ old('tujuan_ke') }}">
                                            @error('tujuan_ke')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Pemeriksaan --}}
                    <div class="col-md-12">
                        <div class="card h-100 border-light shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-magnifying-glass me-2"></i>Detail Pemeriksaan</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="lokasi_pemeriksaan" class="form-label">Lokasi Pemeriksaan</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-magnifying-glass"></i></span>
                                            <input type="text" class="form-control @error('lokasi_pemeriksaan') is-invalid @enderror" id="lokasi_pemeriksaan" name="lokasi_pemeriksaan" value="{{ old('lokasi_pemeriksaan') }}">
                                            @error('lokasi_pemeriksaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jenis_pemeriksaan" class="form-label">Jenis Pemeriksaan</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-list"></i></span>
                                            <select class="form-select @error('jenis_pemeriksaan') is-invalid @enderror" id="jenis_pemeriksaan" name="jenis_pemeriksaan">
                                                <option value="" disabled selected>Pilih...</option>
                                                <option value="Membuka Pakaian" {{ old('jenis_pemeriksaan') == 'Membuka Pakaian' ? 'selected' : '' }}>Membuka Pakaian</option>
                                                <option value="Tidak Membuka Pakaian" {{ old('jenis_pemeriksaan') == 'Tidak Membuka Pakaian' ? 'selected' : '' }}>Tidak Membuka Pakaian</option>
                                                <option value="Medis" {{ old('jenis_pemeriksaan') == 'Medis' ? 'selected' : '' }}>Medis</option>
                                            </select>
                                            @error('jenis_pemeriksaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="hasil_pemeriksaan" class="form-label">Hasil Pemeriksaan</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-task"></i></span>
                                            <textarea class="form-control @error('hasil_pemeriksaan') is-invalid @enderror" id="hasil_pemeriksaan" name="hasil_pemeriksaan" rows="3">{{ old('hasil_pemeriksaan') }}</textarea>
                                            @error('hasil_pemeriksaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Informasi Tambahan --}}
                    <div class="col-md-12">
                        <div class="card h-100 border-light shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-briefcase me-2"></i>Informasi Tambahan</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="rekan_perjalanan" class="form-label">Rekan Seperjalanan</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-group"></i></span>
                                            <input type="text" class="form-control @error('rekan_perjalanan') is-invalid @enderror" id="rekan_perjalanan" name="rekan_perjalanan" value="{{ old('rekan_perjalanan') }}">
                                            @error('rekan_perjalanan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nama_sarkut" class="form-label">Nama dan Jenis Sarkut</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-boat-alt"></i></span>
                                            <input type="text" class="form-control @error('nama_sarkut') is-invalid @enderror" id="nama_sarkut" name="nama_sarkut" value="{{ old('nama_sarkut') }}">
                                            @error('nama_sarkut')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="no_register" class="form-label">No. Register</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-book"></i></span>
                                            <input type="text" class="form-control @error('no_register') is-invalid @enderror" id="no_register" name="no_register" value="{{ old('no_register') }}">
                                            @error('no_register')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jenis_dokumen_barang" class="form-label">Dokumen Barang (Jenis/Nomor/Tgl)</label>
                                        <div class="input-group">
                                           <span class="input-group-text"><i class="cil-file"></i></span>
                                           <input type="text" class="form-control @error('jenis_dokumen_barang') is-invalid @enderror" name="jenis_dokumen_barang" placeholder="Jenis" value="{{ old('jenis_dokumen_barang') }}">
                                           <input type="text" class="form-control @error('nomor_dokumen_barang') is-invalid @enderror" name="nomor_dokumen_barang" placeholder="Nomor" value="{{ old('nomor_dokumen_barang') }}">
                                           <input type="date" class="form-control @error('tgl_dokumen_barang') is-invalid @enderror" name="tgl_dokumen_barang" placeholder="Tanggal" value="{{ old('tgl_dokumen_barang') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Petugas --}}
                    <div class="col-md-12">
                        <div class="card h-100 border-light shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-people me-2"></i>Petugas</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="id_petugas_1" class="form-label">Petugas 1</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-user-follow"></i></span>
                                            <select id="id_petugas_1" class="form-select @error('id_petugas_1') is-invalid @enderror" name="id_petugas_1" required>
                                                <option value="" disabled selected>Pilih Petugas 1</option>
                                                @foreach($petugasData as $petugas)
                                                    <option value="{{ $petugas->id }}" {{ old('id_petugas_1') == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('id_petugas_1')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="id_petugas_2" class="form-label">Petugas 2</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-user-follow"></i></span>
                                            <select id="id_petugas_2" class="form-select @error('id_petugas_2') is-invalid @enderror" name="id_petugas_2">
                                                <option value="" disabled selected>Pilih Petugas 2</option>
                                                @foreach($petugasData as $petugas)
                                                    <option value="{{ $petugas->id }}" {{ old('id_petugas_2') == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('id_petugas_2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end bg-light">
                <a href="{{ route('pemeriksaan-badan.index') }}" class="btn btn-secondary">
                    <i class="cil-x-circle me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="cil-save me-2"></i>Simpan Data Pemeriksaan Badan
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- Script untuk Nomor BA Riksa ---
        const tglInput = document.getElementById('tgl_ba_riksa');
        const form = document.getElementById('createPemeriksaanForm');
        const noBaRiksaNomorInput = document.getElementById('no_ba_riksa_nomor');
        const noBaRiksaHiddenInput = document.getElementById('no_ba_riksa');
        const fetchButton = document.getElementById('fetch-last-number');

        form.addEventListener('submit', function(e) {
            const nomor = noBaRiksaNomorInput.value;
            const date = new Date(tglInput.value);
            const year = date.getFullYear();

            if (nomor && !isNaN(year)) {
                noBaRiksaHiddenInput.value = `BA-${nomor}/Badan/KBC.010202/${year}`;
            } else {
                noBaRiksaHiddenInput.value = '';
            }
        });

        if (fetchButton) {
            fetchButton.addEventListener('click', function() {
                const originalHtml = this.innerHTML;
                this.disabled = true;
                this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

                fetch("{{ route('pemeriksaan-badan.get-last-number') }}")
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Gagal mengambil data. Status: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.next_number) {
                            noBaRiksaNomorInput.value = data.next_number;
                        } else {
                            alert('Tidak dapat menemukan nomor berikutnya.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan: ' + error.message);
                    })
                    .finally(() => {
                        this.disabled = false;
                        this.innerHTML = originalHtml;
                    });
            });
        }

        // --- Script untuk Surat Perintah ---
        const suratPerintahData = @json($suratPerintahData);
        const nomorSuratInput = document.getElementById('no_surat_perintah');
        const tanggalSuratInput = document.getElementById('tgl_surat_perintah');
        const prefix = 'PRIN-';

        function autofillTanggal() {
            const nomorDipilih = nomorSuratInput.value;
            const dataCocok = suratPerintahData.find(surat => surat.nomor_prin === nomorDipilih);

            if (dataCocok) {
                tanggalSuratInput.value = dataCocok.tanggal_prin.split('T')[0];
            } else {
                tanggalSuratInput.value = '';
            }
        }

        function enforcePrefix() {
            if (!nomorSuratInput.value.startsWith(prefix)) {
                nomorSuratInput.value = prefix;
            }
        }

        nomorSuratInput.addEventListener('keydown', function(e) {
            const { value, selectionStart } = e.target;
            if ((e.key === 'Backspace' && selectionStart <= prefix.length) ||
                (e.key === 'Delete' && selectionStart < prefix.length)) {
                e.preventDefault();
            }
        });

        nomorSuratInput.addEventListener('input', function() {
            enforcePrefix();
            autofillTanggal();
        });

        nomorSuratInput.addEventListener('focus', function() {
            if (nomorSuratInput.value === '') {
                nomorSuratInput.value = prefix;
            }
        });

        if (nomorSuratInput.value) {
            autofillTanggal();
        }
    });
</script>
@endpush
