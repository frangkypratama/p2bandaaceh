@extends('layouts.app')

@section('title', 'Input SBP')

@section('content')
<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0"><strong>Input Surat Bukti Penindakan (SBP)</strong></h4>
                    <small class="text-medium-emphasis">Lengkapi semua informasi yang diperlukan di bawah ini.</small>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('sbp.store') }}" class="row g-3" id="sbpForm">
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
                                                    <input id="nomor_sbp" type="number" class="form-control" name="nomor_sbp" value="{{ old('nomor_sbp') }}" placeholder="Masukkan hanya angka" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tanggal_sbp" class="form-label">Tanggal SBP</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-calendar"></i></span>
                                                    <input id="tanggal_sbp" type="date" class="form-control" name="tanggal_sbp" value="{{ old('tanggal_sbp') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nomor_surat_perintah" class="form-label">Nomor Surat Perintah</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-file"></i></span>
                                                    <input id="nomor_surat_perintah" type="text" class="form-control" name="nomor_surat_perintah" value="{{ old('nomor_surat_perintah') }}" placeholder="Contoh: PRIN-1/KBC.0102/2025" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tanggal_surat_perintah" class="form-label">Tanggal Surat Perintah</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-calendar"></i></span>
                                                    <input id="tanggal_surat_perintah" type="date" class="form-control" name="tanggal_surat_perintah" value="{{ old('tanggal_surat_perintah') }}" required>
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
                                            <input id="nama_pelaku" type="text" class="form-control" name="nama_pelaku" value="{{ old('nama_pelaku') }}" placeholder="Nama lengkap pelaku" required>
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
                                                        <option value="Paspor" {{ old('jenis_identitas') == 'Paspor' ? 'selected' : '' }}>Paspor</option>
                                                        <option value="KTP" {{ old('jenis_identitas') == 'KTP' ? 'selected' : '' }}>KTP</option>
                                                        <option value="SIM" {{ old('jenis_identitas') == 'SIM' ? 'selected' : '' }}>SIM</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nomor_identitas" class="form-label">Nomor Identitas</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-info"></i></span>
                                                    <input id="nomor_identitas" type="text" class="form-control" name="nomor_identitas" value="{{ old('nomor_identitas') }}" placeholder="Nomor identitas pelaku" required>
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
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label for="lokasi_penindakan" class="form-label">Lokasi Penindakan</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-location-pin"></i></span>
                                                <input id="lokasi_penindakan" type="text" class="form-control" name="lokasi_penindakan" value="{{ old('lokasi_penindakan') }}" placeholder="Contoh: Bandara Internasional Sultan Iskandar Muda" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="waktu_penindakan" class="form-label">Waktu Penindakan</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-clock"></i></span>
                                                <input id="waktu_penindakan" type="time" class="form-control" name="waktu_penindakan" value="{{ old('waktu_penindakan') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-3">
                                            <label for="kota" class="form-label">Kota</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-building"></i></span>
                                                <select id="kota" class="form-select" name="kota">
                                                    <option selected disabled value="">Pilih Kota...</option>
                                                    <option value="Banda Aceh" {{ old('kota') == 'Banda Aceh' ? 'selected' : '' }}>Banda Aceh</option>
                                                    <option value="Aceh Besar" {{ old('kota') == 'Aceh Besar' ? 'selected' : '' }}>Aceh Besar</option>
                                                    <option value="Pidie" {{ old('kota') == 'Pidie' ? 'selected' : '' }}>Pidie</option>
                                                    <option value="Pidie Jaya" {{ old('kota') == 'Pidie Jaya' ? 'selected' : '' }}>Pidie Jaya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="kecamatan" class="form-label">Kecamatan</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-map"></i></span>
                                                <input id="kecamatan" type="text" class="form-control" name="kecamatan" value="{{ old('kecamatan') }}" placeholder="Contoh: Jaya Baru">
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
                                    <div class="col-12">
                                        <label for="alasan_penindakan" class="form-label">Alasan Penindakan / Dugaan Pelanggaran</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-warning"></i></span>
                                            <textarea id="alasan_penindakan" class="form-control" name="alasan_penindakan" rows="3" placeholder="Jelaskan secara singkat alasan penindakan atau dugaan pelanggaran" required>{{ old('alasan_penindakan') }}</textarea>
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
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="jenis_barang" class="form-label">Jenis Barang</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-layers"></i></span>
                                                    <input id="jenis_barang" type="text" class="form-control" name="jenis_barang" value="{{ old('jenis_barang') }}" placeholder="Contoh: Minuman Keras" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-calculator"></i></span>
                                                    <input id="jumlah_barang" type="number" class="form-control" name="jumlah_barang" value="{{ old('jumlah_barang') }}" placeholder="0" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="jenis_satuan" class="form-label">Jenis Satuan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-puzzle"></i></span>
                                                    <select id="jenis_satuan" class="form-select" name="jenis_satuan" required>
                                                        <option selected disabled value="">Pilih Satuan...</option>
                                                        <option value="Pcs" {{ old('jenis_satuan') == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                                        <option value="Pkg" {{ old('jenis_satuan') == 'Pkg' ? 'selected' : '' }}>Package</option>
                                                        <option value="Unit" {{ old('jenis_satuan') == 'Unit' ? 'selected' : '' }}>Unit</option>
                                                        <option value="Batang" {{ old('jenis_satuan') == 'Batang' ? 'selected' : '' }}>Batang</option>
                                                        <option value="Botol" {{ old('jenis_satuan') == 'Botol' ? 'selected' : '' }}>Botol</option>
                                                        <option value="Gram" {{ old('jenis_satuan') == 'Gram' ? 'selected' : '' }}>Gram</option>
                                                        <option value="Kilogram" {{ old('jenis_satuan') == 'Kilogram' ? 'selected' : '' }}>Kilogram</option>
                                                        <option value="Buah" {{ old('jenis_satuan') == 'Buah' ? 'selected' : '' }}>Buah</option>
                                                        <option value="Bungkus" {{ old('jenis_satuan') == 'Bungkus' ? 'selected' : '' }}>Bungkus</option>
                                                        <option value="Kotak" {{ old('jenis_satuan') == 'Kotak' ? 'selected' : '' }}>Kotak</option>
                                                        <option value="Liter" {{ old('jenis_satuan') == 'Liter' ? 'selected' : '' }}>Liter</option>
                                                        <option value="Mililiter" {{ old('jenis_satuan') == 'Mililiter' ? 'selected' : '' }}>Mililiter</option>
                                                        <option value="Karton" {{ old('jenis_satuan') == 'Karton' ? 'selected' : '' }}>Karton</option>
                                                        <option value="Set" {{ old('jenis_satuan') == 'Set' ? 'selected' : '' }}>Set</option>
                                                        <option value="Pasang" {{ old('jenis_satuan') == 'Pasang' ? 'selected' : '' }}>Pasang</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="uraian_barang" class="form-label">Uraian Barang</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-description"></i></span>
                                            <textarea id="uraian_barang" class="form-control" name="uraian_barang" rows="3" placeholder="Jelaskan secara detail mengenai barang bukti" required>{{ old('uraian_barang') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="flag_bast" id="flag_bast" value="1" {{ old('flag_bast') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flag_bast">
                                            Apakah diserah terimakan ke Instansi Terkait?
                                        </label>
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
                                                <label for="id_petugas_1" class="form-label">Petugas 1</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="cil-user-follow"></i></span>
                                                    <select id="id_petugas_1" class="form-select" name="id_petugas_1" required>
                                                        <option selected disabled value="">Pilih Petugas 1...</option>
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
                                                    <span class="input-group-text"><i class="cil-user-follow"></i></span>
                                                     <select id="id_petugas_2" class="form-select" name="id_petugas_2" required>
                                                        <option selected disabled value="">Pilih Petugas 2...</option>
                                                        @foreach($petugasData as $petugas)
                                                            <option value="{{ $petugas->id }}" {{ old('id_petugas_2') == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Hidden BAST Fields --}}
                        <input type="hidden" name="nomor_bast" id="hidden_nomor_bast" value="{{ old('nomor_bast') }}">
                        <input type="hidden" name="tanggal_bast" id="hidden_tanggal_bast" value="{{ old('tanggal_bast') }}">
                        <input type="hidden" name="jenis_dokumen" id="hidden_jenis_dokumen" value="{{ old('jenis_dokumen') }}">
                        <input type="hidden" name="tanggal_dokumen" id="hidden_tanggal_dokumen" value="{{ old('tanggal_dokumen') }}">
                        <input type="hidden" name="petugas_eksternal" id="hidden_petugas_eksternal" value="{{ old('petugas_eksternal') }}">
                        <input type="hidden" name="nip_nrp_petugas_eksternal" id="hidden_nip_nrp_petugas_eksternal" value="{{ old('nip_nrp_petugas_eksternal') }}">
                        <input type="hidden" name="instansi_eksternal" id="hidden_instansi_eksternal" value="{{ old('instansi_eksternal') }}">
                        <input type="hidden" name="dalam_rangka" id="hidden_dalam_rangka" value="{{ old('dalam_rangka') }}">

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

<!-- Modal BAST -->
<div class="modal fade" id="bastModal" tabindex="-1" aria-labelledby="bastModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bastModalLabel">Input Berita Acara Serah Terima (BAST)</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_nomor_bast" class="form-label" >Nomor BAST</label>
                            <input type="text" class="form-control" id="modal_nomor_bast" placeholder="Contoh: BAST-1/KBC.010202/2025">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_tanggal_bast" class="form-label">Tanggal BAST</label>
                            <input type="date" class="form-control" id="modal_tanggal_bast">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_jenis_dokumen" class="form-label">Jenis Dokumen</label>
                            <input type="text" class="form-control" id="modal_jenis_dokumen" placeholder="Contoh: Surat Pemberitahuan">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_tanggal_dokumen" class="form-label">Tanggal Dokumen</label>
                            <input type="date" class="form-control" id="modal_tanggal_dokumen">
                        </div>
                    </div>
                </div>

                <hr>
                <h6 class="mt-4">Pihak Eksternal</h6>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_petugas_eksternal" class="form-label">Nama Petugas</label>
                            <input type="text" class="form-control" id="modal_petugas_eksternal">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_nip_nrp_petugas_eksternal" class="form-label">NIP/NRP Petugas</label>
                            <input type="text" class="form-control" id="modal_nip_nrp_petugas_eksternal">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="modal_instansi_eksternal" class="form-label">Instansi</label>
                    <input type="text" class="form-control" id="modal_instansi_eksternal" placeholder="Contoh: Badan Karantina Indonesia">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="modal_dalam_rangka" class="form-label">Dalam Rangka</label>
                    <textarea class="form-control" id="modal_dalam_rangka" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveBastButton">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const flagBastCheckbox = document.getElementById('flag_bast');
        const saveBastButton = document.getElementById('saveBastButton');
        const bastModalElement = document.getElementById('bastModal');
        
        if (!bastModalElement || !flagBastCheckbox || !saveBastButton) {
            console.error('One or more required elements for the BAST modal are missing.');
            return;
        }

        const bastModal = coreui.Modal.getOrCreateInstance(bastModalElement);

        // Function to load data from hidden inputs to modal
        function loadModalData() {
            document.getElementById('modal_nomor_bast').value = document.getElementById('hidden_nomor_bast').value;
            document.getElementById('modal_tanggal_bast').value = document.getElementById('hidden_tanggal_bast').value;
            document.getElementById('modal_jenis_dokumen').value = document.getElementById('hidden_jenis_dokumen').value;
            document.getElementById('modal_tanggal_dokumen').value = document.getElementById('hidden_tanggal_dokumen').value;
            document.getElementById('modal_petugas_eksternal').value = document.getElementById('hidden_petugas_eksternal').value;
            document.getElementById('modal_nip_nrp_petugas_eksternal').value = document.getElementById('hidden_nip_nrp_petugas_eksternal').value;
            document.getElementById('modal_instansi_eksternal').value = document.getElementById('hidden_instansi_eksternal').value;
            document.getElementById('modal_dalam_rangka').value = document.getElementById('hidden_dalam_rangka').value;
        }

        flagBastCheckbox.addEventListener('change', function () {
            if (this.checked) {
                loadModalData();
                bastModal.show();
            }
        });

        saveBastButton.addEventListener('click', function () {
            // Transfer data from modal to hidden inputs
            document.getElementById('hidden_nomor_bast').value = document.getElementById('modal_nomor_bast').value;
            document.getElementById('hidden_tanggal_bast').value = document.getElementById('modal_tanggal_bast').value;
            document.getElementById('hidden_jenis_dokumen').value = document.getElementById('modal_jenis_dokumen').value;
            document.getElementById('hidden_tanggal_dokumen').value = document.getElementById('modal_tanggal_dokumen').value;
            document.getElementById('hidden_petugas_eksternal').value = document.getElementById('modal_petugas_eksternal').value;
            document.getElementById('hidden_nip_nrp_petugas_eksternal').value = document.getElementById('modal_nip_nrp_petugas_eksternal').value;
            document.getElementById('hidden_instansi_eksternal').value = document.getElementById('modal_instansi_eksternal').value;
            document.getElementById('hidden_dalam_rangka').value = document.getElementById('modal_dalam_rangka').value;
            
            bastModal.hide();
        });

        bastModalElement.addEventListener('hidden.coreui.modal', function () {
            const nomorBastHidden = document.getElementById('hidden_nomor_bast');
            if (!nomorBastHidden.value) { 
                flagBastCheckbox.checked = false;
            }
        });
        
        // If there are old BAST values (e.g., due to validation failure), check the box.
        if (document.getElementById('hidden_nomor_bast').value) {
            flagBastCheckbox.checked = true;
        }
    });
</script>
@endpush
