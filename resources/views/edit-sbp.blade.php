@extends('layouts.app')

@section('title', 'Edit SBP')

@section('content')
<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><strong>Edit Surat Bukti Penindakan (SBP)</strong></h5>
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

                        {{-- Menggunakan Partial untuk Form Penomoran yang konsisten --}}
                        @include('input-sbp.partials._penomoran')

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
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="no_hp" class="form-label">Nomor Handphone</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-phone"></i></span>
                                                <input id="no_hp" type="tel" class="form-control" name="no_hp" value="{{ old('no_hp', $sbp->no_hp) }}" placeholder="Contoh: 081234567890">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-wc"></i></span>
                                                <select id="jenis_kelamin" class="form-select" name="jenis_kelamin">
                                                    <option value="">Pilih Jenis Kelamin...</option>
                                                    <option value="Laki-laki" {{ old('jenis_kelamin', $sbp->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                    <option value="Perempuan" {{ old('jenis_kelamin', $sbp->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat_di_indonesia" class="form-label">Alamat di Indonesia</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-location-pin"></i></span>
                                            <textarea id="alamat_di_indonesia" class="form-control" name="alamat_di_indonesia" rows="3" placeholder="Alamat lengkap pelaku di Indonesia">{{ old('alamat_di_indonesia', $sbp->alamat_di_indonesia) }}</textarea>
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
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label for="jenis_barang" class="form-label">Jenis Barang</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-layers"></i></span>
                                                <select id="jenis_barang" class="form-select" name="jenis_barang" required>
                                                    <option selected disabled value="">Silahkan Pilih Jenis Barang...</option>
                                                    @foreach($jenisBarang as $barang)
                                                        <option value="{{ $barang->nama_barang }}" {{ old('jenis_barang', $sbp->jenis_barang) == $barang->nama_barang ? 'selected' : '' }}>
                                                            {{ $barang->nomor_urut }}. {{ $barang->nama_barang }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="kondisi_barang" class="form-label">Kondisi Barang</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="cil-3d"></i></span>
                                                <select id="kondisi_barang" class="form-select" name="kondisi_barang">
                                                    <option value="">Pilih Kondisi...</option>
                                                    <option value="Baru" {{ old('kondisi_barang', $sbp->kondisi_barang) == 'Baru' ? 'selected' : '' }}>Baru</option>
                                                    <option value="Bukan Baru" {{ old('kondisi_barang', $sbp->kondisi_barang) == 'Bukan Baru' ? 'selected' : '' }}>Bukan Baru</option>
                                                </select>
                                            </div>
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
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">BAST</label>
                                            <div id="bast-control-container">
                                                {{-- This will be dynamically updated by JavaScript --}}
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">BA Musnah</label>
                                            <div id="ba-musnah-control-container">
                                                {{-- This will be dynamically updated by JavaScript --}}
                                            </div>
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

                        {{-- Hidden BA Musnah Fields --}}
                        <input type="hidden" name="flag_ba_musnah" id="hidden_flag_ba_musnah" value="{{ old('flag_ba_musnah', $sbp->flag_ba_musnah ?? 0) }}">
                        <input type="hidden" name="nomor_ba_musnah" id="hidden_nomor_ba_musnah" value="{{ old('nomor_ba_musnah', $sbp->nomor_ba_musnah ?? '') }}">
                        <input type="hidden" name="delete_ba_musnah" id="hidden_delete_ba_musnah" value="0">

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
@include('input-sbp.partials._ba_musnah_modal')
@include('input-sbp.partials._pelanggaran_modal')

@endsection

@push('scripts')
<script>
    // ... (JavaScript code remains unchanged)
</script>
@endpush
