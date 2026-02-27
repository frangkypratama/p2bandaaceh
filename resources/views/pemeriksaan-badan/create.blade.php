@extends('layouts.app')

@section('content')
<div class="container-lg">
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Input Pemeriksaan Badan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pemeriksaan-badan.store') }}" method="POST" id="createPemeriksaanForm">
                @csrf
                <h5 class="mb-3">Penomoran</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="no_ba_riksa_nomor" class="form-label">Nomor BA Riksa Badan</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-notes"></i></span>
                                <input type="text" class="form-control" id="no_ba_riksa_nomor" placeholder="Masukkan hanya angka" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                            <input type="hidden" name="no_ba_riksa" id="no_ba_riksa">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tgl_ba_riksa" class="form-label">Tanggal BA Riksa Badan</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-calendar"></i></span>
                                <input type="date" class="form-control" id="tgl_ba_riksa" name="tgl_ba_riksa" value="{{ old('tgl_ba_riksa') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="no_surat_perintah" class="form-label">Nomor Surat Perintah</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-file"></i></span>
                                <input class="form-control" list="datalistOptions" id="no_surat_perintah" name="no_surat_perintah" placeholder="Ketik untuk mencari..." value="{{ old('no_surat_perintah', 'PRIN-') }}" required>
                                <datalist id="datalistOptions">
                                    @foreach($suratPerintahData as $sp)
                                        <option value="{{ $sp->nomor_prin }}">
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tgl_surat_perintah" class="form-label">Tanggal Surat Perintah</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-calendar"></i></span>
                                <input type="date" class="form-control" id="tgl_surat_perintah" name="tgl_surat_perintah" value="{{ old('tgl_surat_perintah') }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="mb-3">Data Pelaku</h5>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-user"></i></span>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-credit-card"></i></span>
                                <select class="form-select" id="jenis_identitas" name="jenis_identitas">
                                    <option value="" disabled selected>Pilih...</option>
                                    <option value="Paspor" {{ old('jenis_identitas') == 'Paspor' ? 'selected' : '' }}>Paspor</option>
                                    <option value="Kartu Tanda Penduduk" {{ old('jenis_identitas') == 'Kartu Tanda Penduduk' ? 'selected' : '' }}>Kartu Tanda Penduduk</option>
                                    <option value="KITAS" {{ old('jenis_identitas') == 'KITAS' ? 'selected' : '' }}>KITAS</option>
                                    <option value="Kartu Keluarga" {{ old('jenis_identitas') == 'Kartu Keluarga' ? 'selected' : '' }}>Kartu Keluarga</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="no_identitas" class="form-label">Nomor Identitas</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-info"></i></span>
                                <input type="text" class="form-control" id="no_identitas" name="no_identitas" value="{{ old('no_identitas') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-location-pin"></i></span>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-calendar"></i></span>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-wc"></i></span>
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="" disabled selected>Pilih...</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-globe-alt"></i></span>
                                <select class="form-select" id="kewarganegaraan" name="kewarganegaraan">
                                    <option value="" disabled selected>Pilih Kewarganegaraan...</option>
                                    @foreach ($nationalities as $nationality)
                                        <option value="{{ $nationality }}" {{ old('kewarganegaraan') == $nationality ? 'selected' : '' }}>
                                            {{ $nationality }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="alamat_pada_identitas" class="form-label">Alamat Sesuai Identitas</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-map"></i></span>
                        <textarea class="form-control" id="alamat_pada_identitas" name="alamat_pada_identitas" rows="2">{{ old('alamat_pada_identitas') }}</textarea>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="alamat_tinggal" class="form-label">Alamat Tempat Tinggal Saat Ini</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-home"></i></span>
                        <textarea class="form-control" id="alamat_tinggal" name="alamat_tinggal" rows="2">{{ old('alamat_tinggal') }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="datang_dari" class="form-label">Datang Dari</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-flight-takeoff"></i></span>
                                <input type="text" class="form-control" id="datang_dari" name="datang_dari" value="{{ old('datang_dari') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tujuan_ke" class="form-label">Tujuan Ke</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-location-pin"></i></span>
                                <input type="text" class="form-control" id="tujuan_ke" name="tujuan_ke" value="{{ old('tujuan_ke') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="mb-3">Detail Pemeriksaan</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="lokasi_pemeriksaan" class="form-label">Lokasi Pemeriksaan</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-magnifying-glass"></i></span>
                                <input type="text" class="form-control" id="lokasi_pemeriksaan" name="lokasi_pemeriksaan" value="{{ old('lokasi_pemeriksaan') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jenis_pemeriksaan" class="form-label">Jenis Pemeriksaan</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-list"></i></span>
                                <select class="form-select" id="jenis_pemeriksaan" name="jenis_pemeriksaan">
                                    <option value="" disabled selected>Pilih...</option>
                                    <option value="Membuka Pakaian" {{ old('jenis_pemeriksaan') == 'Membuka Pakaian' ? 'selected' : '' }}>Membuka Pakaian</option>
                                    <option value="Tidak Membuka Pakaian" {{ old('jenis_pemeriksaan') == 'Tidak Membuka Pakaian' ? 'selected' : '' }}>Tidak Membuka Pakaian</option>
                                    <option value="Medis" {{ old('jenis_pemeriksaan') == 'Medis' ? 'selected' : '' }}>Medis</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="hasil_pemeriksaan" class="form-label">Hasil Pemeriksaan</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-task"></i></span>
                        <textarea class="form-control" id="hasil_pemeriksaan" name="hasil_pemeriksaan" rows="3">{{ old('hasil_pemeriksaan') }}</textarea>
                    </div>
                </div>

                <hr>
                <h5 class="mb-3">Informasi Tambahan</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="rekan_perjalanan" class="form-label">Rekan Seperjalanan</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-group"></i></span>
                                <input type="text" class="form-control" id="rekan_perjalanan" name="rekan_perjalanan" value="{{ old('rekan_perjalanan') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_sarkut" class="form-label">Nama dan Jenis Sarkut</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-boat-alt"></i></span>
                                <input type="text" class="form-control" id="nama_sarkut" name="nama_sarkut" value="{{ old('nama_sarkut') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="no_register" class="form-label">No. Register</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-book"></i></span>
                                <input type="text" class="form-control" id="no_register" name="no_register" value="{{ old('no_register') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="dokumen_barang" class="form-label">Dokumen Barang (Jenis/Nomor/Tgl)</label>
                            <div class="input-group">
                               <span class="input-group-text"><i class="cil-file"></i></span>
                               <input type="text" class="form-control" name="jenis_dokumen_barang" placeholder="Jenis" value="{{ old('jenis_dokumen_barang') }}">
                               <input type="text" class="form-control" name="nomor_dokumen_barang" placeholder="Nomor" value="{{ old('nomor_dokumen_barang') }}">
                               <input type="date" class="form-control" name="tgl_dokumen_barang" placeholder="Tanggal" value="{{ old('tgl_dokumen_barang') }}">
                           </div>
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="mb-3">Petugas</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_petugas_1" class="form-label">Petugas 1</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-user"></i></span>
                                <select id="id_petugas_1" class="form-select" name="id_petugas_1" required>
                                    <option value="" disabled selected>Pilih Petugas 1</option>
                                    @foreach($petugasData as $petugas)
                                        <option value="{{ $petugas->id }}" {{ old('id_petugas_1') == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_petugas_2" class="form-label">Petugas 2</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-user"></i></span>
                                 <select id="id_petugas_2" class="form-select" name="id_petugas_2">
                                    <option value="" disabled selected>Pilih Petugas 2</option>
                                    @foreach($petugasData as $petugas)
                                        <option value="{{ $petugas->id }}" {{ old('id_petugas_2') == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary"><i class="cil-save"></i> Simpan</button>
                    <a href="{{ route('pemeriksaan-badan.index') }}" class="btn btn-secondary"><i class="cil-x-circle"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- Script untuk Nomor BA Riksa ---
        const tglInput = document.getElementById('tgl_ba_riksa');
        const form = document.getElementById('createPemeriksaanForm');
        const noBaRiksaNomorInput = document.getElementById('no_ba_riksa_nomor');
        const noBaRiksaHiddenInput = document.getElementById('no_ba_riksa');

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
