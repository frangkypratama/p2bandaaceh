@extends('layouts.app')

@section('title', 'Edit SBP')

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

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('sbp.update', $sbp->id) }}" class="row g-3" id="editSbpForm">
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
                                        <div class="col-md-6 mb-3">
                                            <label for="nomor_sbp" class="form-label">Nomor SBP</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-notes"></i></span>
                                                <input id="nomor_sbp" type="number" class="form-control @error('nomor_sbp_final') is-invalid @enderror" name="nomor_sbp" value="{{ old('nomor_sbp', $sbp->nomor_sbp_int) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_sbp" class="form-label">Tanggal SBP</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-calendar"></i></span>
                                                <input id="tanggal_sbp" type="date" class="form-control" name="tanggal_sbp" value="{{ old('tanggal_sbp', $sbp->tanggal_sbp->format('Y-m-d')) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="nomor_surat_perintah" class="form-label">Nomor Surat Perintah</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-file"></i></span>
                                                <input id="nomor_surat_perintah" type="text" class="form-control" name="nomor_surat_perintah" value="{{ old('nomor_surat_perintah', $sbp->nomor_surat_perintah) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_surat_perintah" class="form-label">Tanggal Surat Perintah</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-calendar"></i></span>
                                                <input id="tanggal_surat_perintah" type="date" class="form-control" name="tanggal_surat_perintah" value="{{ old('tanggal_surat_perintah', $sbp->tanggal_surat_perintah->format('Y-m-d')) }}" required>
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
                                            <input id="nama_pelaku" type="text" class="form-control" name="nama_pelaku" value="{{ old('nama_pelaku', $sbp->nama_pelaku) }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-credit-card"></i></span>
                                                <select id="jenis_identitas" class="form-select" name="jenis_identitas" required>
                                                    <option value="Paspor" {{ old('jenis_identitas', $sbp->jenis_identitas) == 'Paspor' ? 'selected' : '' }}>Paspor</option>
                                                    <option value="KTP" {{ old('jenis_identitas', $sbp->jenis_identitas) == 'KTP' ? 'selected' : '' }}>KTP</option>
                                                    <option value="SIM" {{ old('jenis_identitas', $sbp->jenis_identitas) == 'SIM' ? 'selected' : '' }}>SIM</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="nomor_identitas" class="form-label">Nomor Identitas</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-info"></i></span>
                                                <input id="nomor_identitas" type="text" class="form-control" name="nomor_identitas" value="{{ old('nomor_identitas', $sbp->nomor_identitas) }}" required>
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
                                                <input id="lokasi_penindakan" type="text" class="form-control" name="lokasi_penindakan" value="{{ old('lokasi_penindakan', $sbp->lokasi_penindakan) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="waktu_penindakan" class="form-label">Waktu Penindakan</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-clock"></i></span>
                                                <input id="waktu_penindakan" type="time" class="form-control" name="waktu_penindakan" value="{{ old('waktu_penindakan', $sbp->waktu_penindakan) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-3">
                                            <label for="kota" class="form-label">Kota</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-building"></i></span>
                                                <select id="kota" class="form-select" name="kota">
                                                    <option value="Banda Aceh" {{ old('kota', $sbp->kota_penindakan) == 'Banda Aceh' ? 'selected' : '' }}>Banda Aceh</option>
                                                    <option value="Aceh Besar" {{ old('kota', $sbp->kota_penindakan) == 'Aceh Besar' ? 'selected' : '' }}>Aceh Besar</option>
                                                    <option value="Pidie" {{ old('kota', $sbp->kota_penindakan) == 'Pidie' ? 'selected' : '' }}>Pidie</option>
                                                    <option value="Pidie Jaya" {{ old('kota', $sbp->kota_penindakan) == 'Pidie Jaya' ? 'selected' : '' }}>Pidie Jaya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="kecamatan" class="form-label">Kecamatan</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-map"></i></span>
                                                <input id="kecamatan" type="text" class="form-control" name="kecamatan" value="{{ old('kecamatan', $sbp->kecamatan_penindakan) }}" placeholder="Contoh: Jaya Baru">
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
                                    <div class="col-12">
                                        <label for="alasan_penindakan" class="form-label">Alasan Penindakan / Dugaan Pelanggaran</label>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" type="button" data-coreui-toggle="modal" data-coreui-target="#pelanggaranModal">
                                                <i class="cil-list"></i> Pilih dari Daftar
                                            </button>
                                            <textarea id="alasan_penindakan" class="form-control" name="alasan_penindakan" rows="3" placeholder="Jelaskan secara singkat alasan penindakan atau dugaan pelanggaran." required>{{ old('alasan_penindakan', $sbp->alasan_penindakan) }}</textarea>
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
                                            <input id="jenis_barang" type="text" class="form-control" name="jenis_barang" value="{{ old('jenis_barang', $sbp->jenis_barang) }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-calculator"></i></span>
                                                <input id="jumlah_barang" type="number" class="form-control" name="jumlah_barang" value="{{ old('jumlah_barang', $sbp->jumlah_barang) }}" required>
                                        </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="jenis_satuan" class="form-label">Jenis Satuan</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-puzzle"></i></span>
                                                <select id="jenis_satuan" class="form-select" name="jenis_satuan" required>
                                                    <option selected disabled value="">Pilih Satuan...</option>
                                                    @foreach($refSatuanData as $satuan)
                                                        <option value="{{ $satuan->nama_satuan }}" {{ old('jenis_satuan', $sbp->jenis_satuan) == $satuan->nama_satuan ? 'selected' : '' }}>{{ $satuan->nama_satuan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="uraian_barang" class="form-label">Uraian Barang</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-description"></i></span>
                                            <textarea id="uraian_barang" class="form-control" name="uraian_barang" rows="3" required>{{ old('uraian_barang', $sbp->uraian_barang) }}</textarea>
                                        </div>
                                    </div>
                                    <div id="bast-control-container">
                                        {{-- This will be dynamically updated by JavaScript --}}\n                                    </div>
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
                                        <div class="col-md-6 mb-3">
                                            <label for="id_petugas_1" class="form-label">Petugas 1</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-user-follow"></i></span>
                                                <select id="id_petugas_1" class="form-select" name="id_petugas_1" required>
                                                    @foreach($petugasData as $petugas)
                                                        <option value="{{ $petugas->id }}" {{ old('id_petugas_1', $sbp->id_petugas_1) == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="id_petugas_2" class="form-label">Petugas 2</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-user-follow"></i></span>
                                                <select id="id_petugas_2" class="form-select" name="id_petugas_2" required>
                                                    @foreach($petugasData as $petugas)
                                                        <option value="{{ $petugas->id }}" {{ old('id_petugas_2', $sbp->id_petugas_2) == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Hidden BAST Fields --}}
                        <input type="hidden" name="flag_bast" id="hidden_flag_bast" value="{{ old('flag_bast', $sbp->bast ? 1 : 0) }}">
                        <input type="hidden" name="nomor_bast" id="hidden_nomor_bast" value="{{ old('nomor_bast', $sbp->bast?->nomor_bast ?? '') }}">
                        <input type="hidden" name="tanggal_bast" id="hidden_tanggal_bast" value="{{ old('tanggal_bast', $sbp->bast?->tanggal_bast ? $sbp->bast?->tanggal_bast->format('Y-m-d') : '') }}">
                        <input type="hidden" name="jenis_dokumen" id="hidden_jenis_dokumen" value="{{ old('jenis_dokumen', $sbp->bast?->jenis_dokumen ?? '') }}">
                        <input type="hidden" name="tanggal_dokumen" id="hidden_tanggal_dokumen" value="{{ old('tanggal_dokumen', $sbp->bast?->tanggal_dokumen ? $sbp->bast?->tanggal_dokumen->format('Y-m-d') : '') }}">
                        <input type="hidden" name="petugas_eksternal" id="hidden_petugas_eksternal" value="{{ old('petugas_eksternal', $sbp->bast?->petugas_eksternal ?? '') }}">
                        <input type="hidden" name="nip_nrp_petugas_eksternal" id="hidden_nip_nrp_petugas_eksternal" value="{{ old('nip_nrp_petugas_eksternal', $sbp->bast?->nip_nrp_petugas_eksternal ?? '') }}">
                        <input type="hidden" name="instansi_eksternal" id="hidden_instansi_eksternal" value="{{ old('instansi_eksternal', $sbp->bast?->instansi_eksternal ?? '') }}">
                        <input type="hidden" name="dalam_rangka" id="hidden_dalam_rangka" value="{{ old('dalam_rangka', $sbp->bast?->dalam_rangka ?? '') }}">
                        <input type="hidden" name="delete_bast" id="hidden_delete_bast" value="0">

                        <div class="col-12 text-center">
                            <a href="{{ route('sbp.index') }}" class="btn btn-secondary btn">
                                <i class="cil-arrow-circle-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn ms-2">
                                <i class="cil-sync"></i> Perbarui Data SBP
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Include Modals --}}
@include('input-sbp.partials._bast_modal')
@include('input-sbp.partials._pelanggaran_modal')

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- BAST Elements ---
        const bastModalElement = document.getElementById('bastModal');
        const saveBastButton = document.getElementById('saveBastButton');
        const modalDeleteBastBtn = document.getElementById('modalDeleteBastBtn');
        const bastControlContainer = document.getElementById('bast-control-container');
        const form = document.getElementById('editSbpForm');
        const flagBastHidden = document.getElementById('hidden_flag_bast');

        if (bastModalElement && saveBastButton && bastControlContainer) {
            const bastModal = new coreui.Modal(bastModalElement);

            const errors = @json($errors->keys());
            const bastErrorKeys = [
                'nomor_bast', 'tanggal_bast', 'jenis_dokumen', 'tanggal_dokumen',
                'petugas_eksternal', 'nip_nrp_petugas_eksternal', 'instansi_eksternal', 'dalam_rangka'
            ];
            const hasBastErrors = bastErrorKeys.some(key => errors.includes(key));

            // --- MAIN LOGIC ---
            updateBastButtons();

            if (hasBastErrors) {
                bastModal.show();
            }
            
            // --- Event Listeners ---
            bastControlContainer.addEventListener('click', function(event) {
                const target = event.target.closest('button');
                if (!target) return;

                if (target.id === 'createBastBtn' || target.id === 'viewBastBtn') {
                    document.getElementById('modal_nomor_bast').value = document.getElementById('hidden_nomor_bast').value;
                    document.getElementById('modal_tanggal_bast').value = document.getElementById('hidden_tanggal_bast').value;
                    document.getElementById('modal_jenis_dokumen').value = document.getElementById('hidden_jenis_dokumen').value;
                    document.getElementById('modal_tanggal_dokumen').value = document.getElementById('hidden_tanggal_dokumen').value;
                    document.getElementById('modal_petugas_eksternal').value = document.getElementById('hidden_petugas_eksternal').value;
                    document.getElementById('modal_nip_nrp_petugas_eksternal').value = document.getElementById('hidden_nip_nrp_petugas_eksternal').value;
                    document.getElementById('modal_instansi_eksternal').value = document.getElementById('hidden_instansi_eksternal').value;
                    document.getElementById('modal_dalam_rangka').value = document.getElementById('hidden_dalam_rangka').value;
                    bastModal.show();
                }
            });

            saveBastButton.addEventListener('click', function () {
                document.getElementById('hidden_nomor_bast').value = document.getElementById('modal_nomor_bast').value;
                document.getElementById('hidden_tanggal_bast').value = document.getElementById('modal_tanggal_bast').value;
                document.getElementById('hidden_jenis_dokumen').value = document.getElementById('modal_jenis_dokumen').value;
                document.getElementById('hidden_tanggal_dokumen').value = document.getElementById('modal_tanggal_dokumen').value;
                document.getElementById('hidden_petugas_eksternal').value = document.getElementById('modal_petugas_eksternal').value;
                document.getElementById('hidden_nip_nrp_petugas_eksternal').value = document.getElementById('modal_nip_nrp_petugas_eksternal').value;
                document.getElementById('hidden_instansi_eksternal').value = document.getElementById('modal_instansi_eksternal').value;
                document.getElementById('hidden_dalam_rangka').value = document.getElementById('modal_dalam_rangka').value;
                
                flagBastHidden.value = '1';
                document.getElementById('hidden_delete_bast').value = '0'; 

                updateBastButtons();
                bastModal.hide();
            });

            if(modalDeleteBastBtn) {
                modalDeleteBastBtn.addEventListener('click', function() {
                     if (confirm('Apakah Anda yakin ingin menghapus data BAST? Tindakan ini tidak dapat diurungkan.')) {
                        document.getElementById('hidden_delete_bast').value = '1';
                        flagBastHidden.value = '0';
                        clearHiddenBastFields();
                        updateBastButtons();
                        bastModal.hide();
                    }
                });
            }
            
            function clearHiddenBastFields() {
                 document.getElementById('hidden_nomor_bast').value = '';
                 document.getElementById('hidden_tanggal_bast').value = '';
                 document.getElementById('hidden_jenis_dokumen').value = '';
                 document.getElementById('hidden_tanggal_dokumen').value = '';
                 document.getElementById('hidden_petugas_eksternal').value = '';
                 document.getElementById('hidden_nip_nrp_petugas_eksternal').value = '';
                 document.getElementById('hidden_instansi_eksternal').value = '';
                 document.getElementById('hidden_dalam_rangka').value = '';
            }
            
            function updateBastButtons() {
                let hasBast = flagBastHidden.value === '1' && document.getElementById('hidden_delete_bast').value !== '1';
                
                if(hasBast) {
                    bastControlContainer.innerHTML = `
                        <button type="button" class="btn btn-primary" id="viewBastBtn">
                            <i class="cil-share-boxed"></i> Lihat/Edit BAST
                        </button>
                    `;
                } else {
                    bastControlContainer.innerHTML = `
                        <button type="button" class="btn btn-outline-primary" id="createBastBtn">
                            <i class="cil-plus"></i> Buat BAST
                        </button>
                    `;
                }
            }
        }

        // Pelanggaran Modal Logic (unchanged)
        const pelanggaranModalElement = document.getElementById('pelanggaranModal');
        if (pelanggaranModalElement) {
            const alasanTextarea = document.getElementById('alasan_penindakan');
            const pelanggaranModal = new coreui.Modal(pelanggaranModalElement);

            pelanggaranModalElement.addEventListener('click', function(event) {
                const button = event.target.closest('.btn-pilih-pelanggaran');
                if (button) {
                    const selectedPelanggaran = button.getAttribute('data-pelanggaran');
                    alasanTextarea.value = 'Diduga melanggar ' + selectedPelanggaran + '.';
                    pelanggaranModal.hide();
                }
            });
        }
    });
</script>
@endpush
