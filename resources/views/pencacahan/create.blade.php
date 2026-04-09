@extends('layouts.app')

@section('content')
<div class="container-lg">
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Tambah Pencacahan</h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('pencacahan.store') }}" method="POST" id="createPencacahanForm" enctype="multipart/form-data">
                @csrf

                {{-- Penomoran --}}
                <h5 class="mb-3">Penomoran</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="no_ba_cacah_nomor" class="form-label">Nomor BA Cacah</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-notes"></i></span>
                                <input type="text" class="form-control" id="no_ba_cacah_nomor" placeholder="Masukkan hanya angka" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ old('no_ba_cacah_nomor', old('no_ba_cacah') ? preg_replace('/[^0-9]/', '', explode('/', old('no_ba_cacah'))[0]) : '') }}">
                            </div>
                            <input type="hidden" name="no_ba_cacah" id="no_ba_cacah" value="{{ old('no_ba_cacah') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_ba_cacah" class="form-label">Tanggal BA Cacah</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-calendar"></i></span>
                                <input type="date" class="form-control" id="tanggal_ba_cacah" name="tanggal_ba_cacah" value="{{ old('tanggal_ba_cacah') }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                {{-- Detail Cacah --}}
                <h5 class="mb-3">Detail Cacah</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="lokasi_cacah" class="form-label">Lokasi Cacah</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-location-pin"></i></span>
                                <input type="text" class="form-control" id="lokasi_cacah" name="lokasi_cacah" value="{{ old('lokasi_cacah') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                {{-- Petugas --}}
                <h5 class="mb-3">Petugas</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_petugas_1" class="form-label">Petugas 1</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-user"></i></span>
                                <select id="id_petugas_1" class="form-select" name="id_petugas_1" required>
                                    <option value="" selected disabled>Pilih Petugas 1</option>
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
                                    <option value="">Pilih Petugas 2</option>
                                    @foreach($petugasData as $petugas)
                                    <option value="{{ $petugas->id }}" {{ old('id_petugas_2') == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                {{-- Dokumen SBP Terkait --}}
                <h5 class="mb-3">Dokumen Terkait</h5>
                <div class="mb-3">
                    <label class="form-label">Dokumen SBP Terkait</label><br>
                    <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#sbpModal">
                        <i class="cil-file-plus me-2"></i> Tambah SBP
                    </button>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-striped table-hover" id="selectedSbpTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Nomor SBP</th>
                                    <th>Tanggal SBP</th>
                                    <th class="text-center">Status Detail</th>
                                    <th class="text-center">Status Foto</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="selectedSbpTableBody">
                                @if(old('id_sbp') && isset($oldSbpData))
                                    @foreach($oldSbpData as $sbp)
                                    <tr id="selected-row-{{ $sbp->id }}">
                                        <td>{{ $sbp->nomor_sbp }}</td>
                                        <td>{{ \Carbon\Carbon::parse($sbp->tanggal_sbp)->translatedFormat('d F Y') }}</td>
                                        <td class="text-center"><span class="badge bg-secondary" id="status-detail-{{$sbp->id}}">Belum Diisi</span></td>
                                        <td class="text-center"><span class="badge bg-secondary" id="status-foto-{{$sbp->id}}">Belum Diunggah</span></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-info btn-sm text-white btn-detail-sbp"
                                                data-sbp-id="{{ $sbp->id }}"
                                                data-nomor-sbp="{{ $sbp->nomor_sbp }}"
                                                data-tanggal-sbp="{{ $sbp->tanggal_sbp }}"
                                                data-jenis-barang="{{ $sbp->jenis_barang ?? '' }}"
                                                data-uraian-barang="{{ $sbp->uraian_barang ?? '' }}">
                                                <i class="cil-search me-1"></i> Detail
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm text-white btn-hapus-sbp" data-sbp-id="{{ $sbp->id }}">
                                                <i class="cil-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div id="hiddenSbpInputs">
                        @if(old('id_sbp'))
                            @foreach(old('id_sbp') as $sbpId)
                                <input type="hidden" name="id_sbp[]" id="hidden-input-{{ $sbpId }}" value="{{ $sbpId }}">
                                <input type="hidden" name="detail_barang_json[{{$sbpId}}]" id="hidden-barang-json-{{$sbpId}}" value="{{ old("detail_barang_json.$sbpId") }}">
                            @endforeach
                        @endif
                    </div>
                    <div id="hiddenFileInputs" style="display:none;"></div>
                </div>

                <div class="card-footer text-end bg-light">
                    <button type="submit" class="btn btn-primary"><i class="cil-save me-2"></i>Simpan Pencacahan</button>
                    <a href="{{ route('pencacahan.index') }}" class="btn btn-secondary"><i class="cil-x-circle me-2"></i>Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@include('pencacahan.partials._modal_sbp_selection')
@include('pencacahan.partials._modal_sbp_detail')

@endsection

@push('styles')
<style>
    .foto-upload-wrapper { border: 2px dashed #ced4da; border-radius: .375rem; padding: 1.5rem; background-color: #f8f9fa; min-height: 200px; display: flex; align-items: center; justify-content: center; cursor: pointer; }
    #foto_preview_modal { max-height: 250px; object-fit: contain; }
    .row-dicacah { background-color: #e9ecef !important; color: #6c757d; cursor: not-allowed; }
    #sbpPagination .pagination { cursor: pointer; }
    #selectedSbpTable .btn-sm { padding: 0.2rem 0.5rem; font-size: 0.8rem; }
    .form-control-plaintext { padding-top: 0; padding-bottom: 0; }
    .conditional-fields-container { animation: fadeIn 0.3s; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ═══════════════════════════════════════════════════════════════════
    // STATE & REFS
    // ═══════════════════════════════════════════════════════════════════
    const sbpModalElement = document.getElementById('sbpModal');
    const detailSbpModalElement = document.getElementById('detailSbpModal');
    const detailSbpModal = new coreui.Modal(detailSbpModalElement);
    const selectedSbpIds = new Set(@json(old('id_sbp', [])).map(id => id.toString()));
    const satuanOptions = @json($satuanData);
    const jenisBarangOptions = @json($jenisBarangData);
    const tarifCukaiData = @json($tarifCukaiData ?? []);
    const barangContainer = document.getElementById('barangItemsContainer');
    const emptyMessage = document.getElementById('emptyBarangMessage');
    const btnTambah = document.getElementById('btnTambahBarang');

    // ═══════════════════════════════════════════════════════════════════
    // UTILITY
    // ═══════════════════════════════════════════════════════════════════
    function formatTanggal(raw) {
        if (!raw) return '-';
        const d = new Date(raw);
        return isNaN(d.getTime()) ? '-' : d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    }

    function esc(val) {
        if (!val) return '';
        return String(val).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    function sel(current, value) {
        return current === value ? 'selected' : '';
    }

    function buildSatuanOptions(selectedValue = null) {
        let opts = `<option value="" ${!selectedValue ? 'selected' : ''} disabled>Pilih Satuan</option>`;
        satuanOptions.forEach(s => {
            opts += `<option value="${s.id}" ${s.id == selectedValue ? 'selected' : ''}>${esc(s.nama_satuan)}</option>`;
        });
        return opts;
    }

    function buildJenisBarangOptions() {
        return '<option value="" selected disabled>Pilih Jenis Barang</option>' +
            jenisBarangOptions.map((jb, i) => `<option value="${jb.id}" data-nama="${esc(jb.nama_barang)}">${i + 1}. ${esc(jb.nama_barang)}</option>`).join('');
    }

    function buildTarifCukaiOptions(selectedValue = null) {
        let opts = '<option value="" selected disabled>Pilih Jenis Tarif</option>';
        tarifCukaiData.forEach(t => {
            const tarifFormatted = new Intl.NumberFormat('id-ID').format(t.tarif);
            let label = t.jenis;
            if (t.golongan) {
                label += (t.golongan.toLowerCase() === 'tanpa golongan') ? ' - Tanpa Golongan' : ` - Golongan ${t.golongan}`;
            }
            label += ` - Rp ${tarifFormatted}`;
            opts += `<option value="${t.id}" ${t.id == selectedValue ? 'selected' : ''}>${esc(label)}</option>`;
        });
        return opts;
    }

    function updateEmptyMessage() {
        emptyMessage.classList.toggle('d-none', barangContainer.querySelectorAll('.barang-item').length > 0);
    }

    function renumberBarang() {
        barangContainer.querySelectorAll('.barang-item').forEach((item, i) => {
            item.querySelector('.barang-number').textContent = `Barang ${i + 1}`;
        });
    }

    // ═══════════════════════════════════════════════════════════════════
    // DEFAULT FIELDS (untuk jenis yang tidak punya field spesifik)
    // ═══════════════════════════════════════════════════════════════════
    function defaultFieldsHTML(d = {}) {
        return `
            <div class="mb-3">
                <label class="form-label">Uraian / Nama Barang</label>
                <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Bawang Merah Brebes, Nike Air Jordan, dll" value="${esc(d.merek)}">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" class="form-control" data-field="jumlah" min="1" placeholder="0" value="${esc(d.jumlah)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Satuan</label>
                    <select class="form-select" data-field="id_satuan">${buildSatuanOptions(d.id_satuan)}</select>
                </div>
            </div>
        `;
    }

    // ═══════════════════════════════════════════════════════════════════
    // CONDITIONAL FIELDS PER JENIS BARANG
    // ═══════════════════════════════════════════════════════════════════
    function getConditionalFieldsHTML(namaBarang, d = {}) {
        const sf = {};

        // ── 38. Hasil Tembakau ──
        sf['Hasil Tembakau'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Manchester" value="${esc(d.merek)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Tarif Cukai</label>
                    <select class="form-select" data-field="id_ref_tarif_cukai">${buildTarifCukaiOptions(d.id_ref_tarif_cukai)}</select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Bungkus</label>
                    <input type="number" class="form-control" data-field="jumlah_bungkus" min="1" placeholder="10" value="${esc(d.jumlah_bungkus)}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Batang/Bks</label>
                    <input type="number" class="form-control" data-field="jumlah_batang" min="1" placeholder="20" value="${esc(d.jumlah_batang)}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Total Batang</label>
                    <input type="number" class="form-control" data-field="total_batang" readonly value="${(d.jumlah_bungkus || 0) * (d.jumlah_batang || 0)}">
                </div>
            </div>`;

        // ── 9. Handphone, Gadget, Part & Accessories ──
        sf['Handphone, Gadget, Part & Accesories'] = `
            <div class="mb-3">
                <label class="form-label">Merek</label>
                <input type="text" class="form-control" data-field="merek" placeholder="Contoh: iPhone, Samsung" value="${esc(d.merek)}">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">IMEI 1</label>
                    <input type="text" class="form-control" data-field="imei1" placeholder="15 digit" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')" value="${esc(d.imei1)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">IMEI 2 (Opsional)</label>
                    <input type="text" class="form-control" data-field="imei2" placeholder="15 digit" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')" value="${esc(d.imei2)}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Warna</label>
                <input type="text" class="form-control" data-field="warna" placeholder="Contoh: Hitam, Putih" value="${esc(d.warna)}">
            </div>`;

        // ── 10. Elektronik ──
        sf['Elektronik'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Elektronik</label>
                    <input type="text" class="form-control" data-field="jenis_elektronik" placeholder="Contoh: TV, Kulkas" value="${esc(d.jenis_elektronik)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Samsung" value="${esc(d.merek)}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Model / No. Seri</label>
                    <input type="text" class="form-control" data-field="model_seri" placeholder="Contoh: UA43AU7000" value="${esc(d.model_seri)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ukuran</label>
                    <input type="text" class="form-control" data-field="ukuran" placeholder="Contoh: 43 inch" value="${esc(d.ukuran)}">
                </div>
            </div>`;

        // ── 13. Kendaraan Darat ──
        sf['Kendaraan Darat (Bermotor/Tidak), Part & Accessories'] = `
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jenis Kendaraan</label>
                    <select class="form-select" data-field="jenis_kendaraan">
                        <option value="" ${sel(d.jenis_kendaraan,'')}>Pilih Jenis</option>
                        <option value="Mobil" ${sel(d.jenis_kendaraan,'Mobil')}>Mobil</option>
                        <option value="Motor" ${sel(d.jenis_kendaraan,'Motor')}>Motor</option>
                        <option value="Sepeda" ${sel(d.jenis_kendaraan,'Sepeda')}>Sepeda</option>
                        <option value="Lainnya" ${sel(d.jenis_kendaraan,'Lainnya')}>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Toyota" value="${esc(d.merek)}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipe</label>
                    <input type="text" class="form-control" data-field="tipe" placeholder="Contoh: Avanza" value="${esc(d.tipe)}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Rangka</label>
                    <input type="text" class="form-control" data-field="nomor_rangka" value="${esc(d.nomor_rangka)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Mesin</label>
                    <input type="text" class="form-control" data-field="nomor_mesin" value="${esc(d.nomor_mesin)}">
                </div>
            </div>`;

        // ── 14. Kendaraan Air ──
        sf['Kendaraan Air (Bermotor/Tidak), Part & Accessories'] = `
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jenis</label>
                    <select class="form-select" data-field="jenis_kendaraan">
                        <option value="" ${sel(d.jenis_kendaraan,'')}>Pilih Jenis</option>
                        <option value="Kapal" ${sel(d.jenis_kendaraan,'Kapal')}>Kapal</option>
                        <option value="Perahu" ${sel(d.jenis_kendaraan,'Perahu')}>Perahu</option>
                        <option value="Speedboat" ${sel(d.jenis_kendaraan,'Speedboat')}>Speedboat</option>
                        <option value="Lainnya" ${sel(d.jenis_kendaraan,'Lainnya')}>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" class="form-control" data-field="merek" value="${esc(d.merek)}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipe</label>
                    <input type="text" class="form-control" data-field="tipe" value="${esc(d.tipe)}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Lambung (Hull)</label>
                    <input type="text" class="form-control" data-field="nomor_rangka" value="${esc(d.nomor_rangka)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Mesin</label>
                    <input type="text" class="form-control" data-field="nomor_mesin" value="${esc(d.nomor_mesin)}">
                </div>
            </div>`;

        // ── 15. Kendaraan Udara ──
        sf['Kendaraan Udara (Bermotor/Tidak), Part & Accessories'] = `
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jenis</label>
                    <select class="form-select" data-field="jenis_kendaraan">
                        <option value="" ${sel(d.jenis_kendaraan,'')}>Pilih Jenis</option>
                        <option value="Pesawat" ${sel(d.jenis_kendaraan,'Pesawat')}>Pesawat</option>
                        <option value="Helikopter" ${sel(d.jenis_kendaraan,'Helikopter')}>Helikopter</option>
                        <option value="Drone" ${sel(d.jenis_kendaraan,'Drone')}>Drone</option>
                        <option value="Lainnya" ${sel(d.jenis_kendaraan,'Lainnya')}>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" class="form-control" data-field="merek" value="${esc(d.merek)}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipe</label>
                    <input type="text" class="form-control" data-field="tipe" value="${esc(d.tipe)}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Registrasi</label>
                    <input type="text" class="form-control" data-field="nomor_rangka" value="${esc(d.nomor_rangka)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Mesin</label>
                    <input type="text" class="form-control" data-field="nomor_mesin" value="${esc(d.nomor_mesin)}">
                </div>
            </div>`;

        // ── 39. Minuman Mengandung Etil Alkohol ──
        sf['Minuman Mengandung Etil Alkohol'] = `
            <div class="mb-3">
                <label class="form-label">Merek</label>
                <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Johnnie Walker" value="${esc(d.merek)}">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kadar Alkohol (%)</label>
                    <input type="number" class="form-control" data-field="kadar_alkohol" step="0.1" min="0" placeholder="40" value="${esc(d.kadar_alkohol)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Volume (ml)</label>
                    <input type="number" class="form-control" data-field="volume" min="0" placeholder="750" value="${esc(d.volume)}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah Botol</label>
                    <input type="number" class="form-control" data-field="jumlah_botol" min="1" placeholder="12" value="${esc(d.jumlah_botol)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis MMEA</label>
                    <select class="form-select" data-field="jenis_mmea">
                        <option value="" ${sel(d.jenis_mmea,'')}>Pilih Jenis</option>
                        <option value="Bir" ${sel(d.jenis_mmea,'Bir')}>Bir</option>
                        <option value="Anggur" ${sel(d.jenis_mmea,'Anggur')}>Anggur</option>
                        <option value="Spirit" ${sel(d.jenis_mmea,'Spirit')}>Spirit</option>
                        <option value="Lainnya" ${sel(d.jenis_mmea,'Lainnya')}>Lainnya</option>
                    </select>
                </div>
            </div>`;

        // ── 40. Etil Alkohol ──
        sf['Etil Alkohol'] = `
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kadar (%)</label>
                    <input type="number" class="form-control" data-field="kadar_alkohol" step="0.1" min="0" max="100" value="${esc(d.kadar_alkohol)}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Volume (liter)</label>
                    <input type="number" class="form-control" data-field="volume" min="0" step="0.1" value="${esc(d.volume)}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Wadah</label>
                    <input type="number" class="form-control" data-field="jumlah_botol" min="1" value="${esc(d.jumlah_botol)}">
                </div>
            </div>`;

        // ── 41. Pita Cukai ──
        sf['Pita Cukai'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis HT</label>
                    <select class="form-select" data-field="jenis_rokok">
                        <option value="" ${sel(d.jenis_rokok,'')}>Pilih Jenis</option>
                        <option value="SKM" ${sel(d.jenis_rokok,'SKM')}>SKM</option>
                        <option value="SPM" ${sel(d.jenis_rokok,'SPM')}>SPM</option>
                        <option value="SKT" ${sel(d.jenis_rokok,'SKT')}>SKT</option>
                        <option value="SPT" ${sel(d.jenis_rokok,'SPT')}>SPT</option>
                        <option value="SKTF" ${sel(d.jenis_rokok,'SKTF')}>SKTF</option>
                        <option value="SPTF" ${sel(d.jenis_rokok,'SPTF')}>SPTF</option>
                        <option value="TIS" ${sel(d.jenis_rokok,'TIS')}>TIS</option>
                        <option value="KLM" ${sel(d.jenis_rokok,'KLM')}>KLM</option>
                        <option value="KLB" ${sel(d.jenis_rokok,'KLB')}>KLB</option>
                        <option value="CRT" ${sel(d.jenis_rokok,'CRT')}>CRT</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Seri Pita</label>
                    <input type="text" class="form-control" data-field="model_seri" placeholder="Seri pita cukai" value="${esc(d.model_seri)}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tahun</label>
                    <input type="number" class="form-control" data-field="tahun" min="2000" max="2099" placeholder="2025" value="${esc(d.tahun)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah Keping</label>
                    <input type="number" class="form-control" data-field="jumlah" min="1" value="${esc(d.jumlah)}">
                </div>
            </div>`;

        // ── Narkotika, Psikotropika, dan Prekursor ──
        sf['Narkotika, Psikotropika, dan Prekursor'] = `
            <div class="mb-3">
                <label class="form-label">Jenis Zat</label>
                <select class="form-select" data-field="jenis_zat">
                    <option value="" ${sel(d.jenis_zat,'')}>Pilih Jenis</option>
                    <option value="Narkotika" ${sel(d.jenis_zat,'Narkotika')}>Narkotika</option>
                    <option value="Psikotropika" ${sel(d.jenis_zat,'Psikotropika')}>Psikotropika</option>
                    <option value="Prekursor" ${sel(d.jenis_zat,'Prekursor')}>Prekursor</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Zat</label>
                    <input type="text" class="form-control" data-field="nama_zat" placeholder="Contoh: Metamfetamin" value="${esc(d.nama_zat)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Bentuk Sediaan</label>
                    <input type="text" class="form-control" data-field="bentuk_sediaan" placeholder="Contoh: Kristal, Tablet" value="${esc(d.bentuk_sediaan)}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Berat (gram)</label>
                    <input type="number" class="form-control" data-field="berat" step="0.01" min="0" value="${esc(d.berat)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah Kemasan</label>
                    <input type="number" class="form-control" data-field="jumlah_kemasan" min="1" value="${esc(d.jumlah_kemasan)}">
                </div>
            </div>`;

        // ── 20. Senjata Api, Airgun, Airsoftgun ──
        sf['Senjata Api, Airgun, Airsoftgun & Part'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Senjata</label>
                    <select class="form-select" data-field="jenis_kendaraan">
                        <option value="" ${sel(d.jenis_kendaraan,'')}>Pilih Jenis</option>
                        <option value="Senjata Api" ${sel(d.jenis_kendaraan,'Senjata Api')}>Senjata Api</option>
                        <option value="Airgun" ${sel(d.jenis_kendaraan,'Airgun')}>Airgun</option>
                        <option value="Airsoftgun" ${sel(d.jenis_kendaraan,'Airsoftgun')}>Airsoftgun</option>
                        <option value="Part/Amunisi" ${sel(d.jenis_kendaraan,'Part/Amunisi')}>Part/Amunisi</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" class="form-control" data-field="merek" value="${esc(d.merek)}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kaliber</label>
                    <input type="text" class="form-control" data-field="ukuran" placeholder="Contoh: 9mm, .45 ACP" value="${esc(d.ukuran)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Seri</label>
                    <input type="text" class="form-control" data-field="model_seri" value="${esc(d.model_seri)}">
                </div>
            </div>`;

        // ── 37. Uang Tunai / BNI ──
        sf['Uang Tunai /Bni'] = `
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Mata Uang</label>
                    <select class="form-select" data-field="jenis_mmea">
                        <option value="" ${sel(d.jenis_mmea,'')}>Pilih</option>
                        <option value="IDR" ${sel(d.jenis_mmea,'IDR')}>IDR - Rupiah</option>
                        <option value="USD" ${sel(d.jenis_mmea,'USD')}>USD - Dollar AS</option>
                        <option value="SGD" ${sel(d.jenis_mmea,'SGD')}>SGD - Dollar Singapura</option>
                        <option value="MYR" ${sel(d.jenis_mmea,'MYR')}>MYR - Ringgit</option>
                        <option value="Lainnya" ${sel(d.jenis_mmea,'Lainnya')}>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nominal</label>
                    <input type="number" class="form-control" data-field="volume" min="0" value="${esc(d.volume)}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Lembar/Keping</label>
                    <input type="number" class="form-control" data-field="jumlah" min="1" value="${esc(d.jumlah)}">
                </div>
            </div>`;

        // ── 26. CITES (Flora & Fauna) ──
        sf['CITES (Flora & Fauna)'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Ilmiah</label>
                    <input type="text" class="form-control" data-field="nama_zat" placeholder="Contoh: Chelonia mydas" value="${esc(d.nama_zat)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Umum</label>
                    <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Penyu Hijau" value="${esc(d.merek)}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Appendix CITES</label>
                    <select class="form-select" data-field="jenis_zat">
                        <option value="" ${sel(d.jenis_zat,'')}>Pilih Appendix</option>
                        <option value="Appendix I" ${sel(d.jenis_zat,'Appendix I')}>Appendix I</option>
                        <option value="Appendix II" ${sel(d.jenis_zat,'Appendix II')}>Appendix II</option>
                        <option value="Appendix III" ${sel(d.jenis_zat,'Appendix III')}>Appendix III</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kondisi</label>
                    <select class="form-select" data-field="bentuk_sediaan">
                        <option value="" ${sel(d.bentuk_sediaan,'')}>Pilih Kondisi</option>
                        <option value="Hidup" ${sel(d.bentuk_sediaan,'Hidup')}>Hidup</option>
                        <option value="Mati" ${sel(d.bentuk_sediaan,'Mati')}>Mati</option>
                        <option value="Olahan" ${sel(d.bentuk_sediaan,'Olahan')}>Olahan</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" class="form-control" data-field="jumlah" min="1" value="${esc(d.jumlah)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Satuan</label>
                    <select class="form-select" data-field="id_satuan">${buildSatuanOptions(d.id_satuan)}</select>
                </div>
            </div>`;

        // ── 18. Logam Mulia Dan Perhiasan ──
        sf['Logam Mulia Dan Perhiasan'] = `
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jenis</label>
                    <select class="form-select" data-field="jenis_elektronik">
                        <option value="" ${sel(d.jenis_elektronik,'')}>Pilih Jenis</option>
                        <option value="Emas" ${sel(d.jenis_elektronik,'Emas')}>Emas</option>
                        <option value="Perak" ${sel(d.jenis_elektronik,'Perak')}>Perak</option>
                        <option value="Platinum" ${sel(d.jenis_elektronik,'Platinum')}>Platinum</option>
                        <option value="Perhiasan" ${sel(d.jenis_elektronik,'Perhiasan')}>Perhiasan</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kadar (karat/%)</label>
                    <input type="text" class="form-control" data-field="ukuran" placeholder="Contoh: 24K, 99.9%" value="${esc(d.ukuran)}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Berat (gram)</label>
                    <input type="number" class="form-control" data-field="berat" step="0.01" min="0" value="${esc(d.berat)}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Merek / Deskripsi</label>
                <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Antam, Gelang emas" value="${esc(d.merek)}">
            </div>`;

        // ── 36. Crude Oil, Pelumas & BBM ──
        sf['Crude Oil (Minyak Mentah), Pelumas & BBM'] = `
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jenis</label>
                    <select class="form-select" data-field="jenis_elektronik">
                        <option value="" ${sel(d.jenis_elektronik,'')}>Pilih Jenis</option>
                        <option value="Solar" ${sel(d.jenis_elektronik,'Solar')}>Solar</option>
                        <option value="Bensin" ${sel(d.jenis_elektronik,'Bensin')}>Bensin</option>
                        <option value="Pelumas" ${sel(d.jenis_elektronik,'Pelumas')}>Pelumas</option>
                        <option value="Minyak Mentah" ${sel(d.jenis_elektronik,'Minyak Mentah')}>Minyak Mentah</option>
                        <option value="Lainnya" ${sel(d.jenis_elektronik,'Lainnya')}>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Volume (liter)</label>
                    <input type="number" class="form-control" data-field="volume" min="0" step="0.1" value="${esc(d.volume)}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Wadah</label>
                    <input type="number" class="form-control" data-field="jumlah_botol" min="1" value="${esc(d.jumlah_botol)}">
                </div>
            </div>`;

        // ── 42 & 43. CPO & Turunan CPO ──
        sf['Crude Palm Oil (Minyak Sawit)'] = `
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Volume (liter/kg)</label>
                    <input type="number" class="form-control" data-field="volume" min="0" step="0.1" value="${esc(d.volume)}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Wadah</label>
                    <input type="number" class="form-control" data-field="jumlah_botol" min="1" value="${esc(d.jumlah_botol)}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Satuan</label>
                    <select class="form-select" data-field="id_satuan">${buildSatuanOptions(d.id_satuan)}</select>
                </div>
            </div>`;
        sf['Produk Turunan CPO (Kec. Minyak Goreng)'] = sf['Crude Palm Oil (Minyak Sawit)'];

        // ── 25. Bahan Kimia ──
        sf['Bahan Kimia'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Bahan</label>
                    <input type="text" class="form-control" data-field="nama_zat" placeholder="Contoh: Asam Sulfat" value="${esc(d.nama_zat)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor CAS (Opsional)</label>
                    <input type="text" class="form-control" data-field="model_seri" placeholder="Contoh: 7664-93-9" value="${esc(d.model_seri)}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Wujud</label>
                    <select class="form-select" data-field="bentuk_sediaan">
                        <option value="" ${sel(d.bentuk_sediaan,'')}>Pilih Wujud</option>
                        <option value="Cair" ${sel(d.bentuk_sediaan,'Cair')}>Cair</option>
                        <option value="Padat" ${sel(d.bentuk_sediaan,'Padat')}>Padat</option>
                        <option value="Gas" ${sel(d.bentuk_sediaan,'Gas')}>Gas</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Berat/Volume</label>
                    <input type="number" class="form-control" data-field="berat" step="0.01" min="0" value="${esc(d.berat)}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Satuan</label>
                    <select class="form-select" data-field="id_satuan">${buildSatuanOptions(d.id_satuan)}</select>
                </div>
            </div>`;

        // ── 61. Barang & Bahan Radioaktif ──
        sf['Barang & Bahan Radioaktif'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Zat</label>
                    <input type="text" class="form-control" data-field="nama_zat" placeholder="Contoh: Cesium-137" value="${esc(d.nama_zat)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Aktivitas (Bq)</label>
                    <input type="number" class="form-control" data-field="berat" step="0.01" min="0" value="${esc(d.berat)}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Nomor Izin BAPETEN</label>
                <input type="text" class="form-control" data-field="no_bpom" value="${esc(d.no_bpom)}">
            </div>`;

        // ── 27. Hewan Non-CITES ──
        sf['Hewan Dan Bagian Tubuh (Non Cites)'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Hewan</label>
                    <input type="text" class="form-control" data-field="merek" value="${esc(d.merek)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kondisi</label>
                    <select class="form-select" data-field="bentuk_sediaan">
                        <option value="" ${sel(d.bentuk_sediaan,'')}>Pilih Kondisi</option>
                        <option value="Hidup" ${sel(d.bentuk_sediaan,'Hidup')}>Hidup</option>
                        <option value="Mati" ${sel(d.bentuk_sediaan,'Mati')}>Mati</option>
                        <option value="Olahan" ${sel(d.bentuk_sediaan,'Olahan')}>Olahan</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" class="form-control" data-field="jumlah" min="1" value="${esc(d.jumlah)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Satuan</label>
                    <select class="form-select" data-field="id_satuan">${buildSatuanOptions(d.id_satuan)}</select>
                </div>
            </div>`;

        // ── 28. Tumbuhan Non-CITES ──
        sf['Tumbuhan Dan Bagian Tumbuhan (Non Cites)'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Tumbuhan</label>
                    <input type="text" class="form-control" data-field="merek" value="${esc(d.merek)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Bagian</label>
                    <select class="form-select" data-field="bentuk_sediaan">
                        <option value="" ${sel(d.bentuk_sediaan,'')}>Pilih Bagian</option>
                        <option value="Akar" ${sel(d.bentuk_sediaan,'Akar')}>Akar</option>
                        <option value="Batang" ${sel(d.bentuk_sediaan,'Batang')}>Batang</option>
                        <option value="Daun" ${sel(d.bentuk_sediaan,'Daun')}>Daun</option>
                        <option value="Buah" ${sel(d.bentuk_sediaan,'Buah')}>Buah</option>
                        <option value="Utuh" ${sel(d.bentuk_sediaan,'Utuh')}>Utuh</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Berat (kg)</label>
                    <input type="number" class="form-control" data-field="berat" step="0.01" min="0" value="${esc(d.berat)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" class="form-control" data-field="jumlah" min="1" value="${esc(d.jumlah)}">
                </div>
            </div>`;

        // ── 29. Benda Cagar Budaya ──
        sf['Benda Cagar Budaya'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Benda</label>
                    <input type="text" class="form-control" data-field="merek" value="${esc(d.merek)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Periode/Era</label>
                    <input type="text" class="form-control" data-field="model_seri" placeholder="Contoh: Majapahit, Abad ke-14" value="${esc(d.model_seri)}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Bahan</label>
                    <select class="form-select" data-field="bentuk_sediaan">
                        <option value="" ${sel(d.bentuk_sediaan,'')}>Pilih Bahan</option>
                        <option value="Batu" ${sel(d.bentuk_sediaan,'Batu')}>Batu</option>
                        <option value="Logam" ${sel(d.bentuk_sediaan,'Logam')}>Logam</option>
                        <option value="Keramik" ${sel(d.bentuk_sediaan,'Keramik')}>Keramik</option>
                        <option value="Kayu" ${sel(d.bentuk_sediaan,'Kayu')}>Kayu</option>
                        <option value="Lainnya" ${sel(d.bentuk_sediaan,'Lainnya')}>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" class="form-control" data-field="jumlah" min="1" value="${esc(d.jumlah)}">
                </div>
            </div>`;

        // ── 31. Kayu & Rotan Asalan ──
        sf['Kayu & Rotan (Asalan)'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Kayu/Rotan</label>
                    <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Jati, Meranti" value="${esc(d.merek)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Volume (m³)</label>
                    <input type="number" class="form-control" data-field="volume" step="0.01" min="0" value="${esc(d.volume)}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah Batang/Ikat</label>
                    <input type="number" class="form-control" data-field="jumlah" min="1" value="${esc(d.jumlah)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Satuan</label>
                    <select class="form-select" data-field="id_satuan">${buildSatuanOptions(d.id_satuan)}</select>
                </div>
            </div>`;

        // ── 30. Produk Melanggar HAKI ──
        sf['Produk Melanggar Haki'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Merek Asli yang Dilanggar</label>
                    <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Nike, Louis Vuitton" value="${esc(d.merek)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Merek Palsu / Label</label>
                    <input type="text" class="form-control" data-field="nama_produk" value="${esc(d.nama_produk)}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jenis Pelanggaran</label>
                    <select class="form-select" data-field="jenis_elektronik">
                        <option value="" ${sel(d.jenis_elektronik,'')}>Pilih Jenis</option>
                        <option value="Merek" ${sel(d.jenis_elektronik,'Merek')}>Merek</option>
                        <option value="Hak Cipta" ${sel(d.jenis_elektronik,'Hak Cipta')}>Hak Cipta</option>
                        <option value="Paten" ${sel(d.jenis_elektronik,'Paten')}>Paten</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" class="form-control" data-field="jumlah" min="1" value="${esc(d.jumlah)}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Satuan</label>
                    <select class="form-select" data-field="id_satuan">${buildSatuanOptions(d.id_satuan)}</select>
                </div>
            </div>`;

        // ── 50. Alat Kesehatan ──
        sf['Alat Kesehatan'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Alat</label>
                    <input type="text" class="form-control" data-field="nama_produk" value="${esc(d.nama_produk)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" class="form-control" data-field="merek" value="${esc(d.merek)}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">No. Izin Edar (Kemenkes)</label>
                    <input type="text" class="form-control" data-field="no_bpom" value="${esc(d.no_bpom)}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kelas Risiko</label>
                    <select class="form-select" data-field="bentuk_sediaan">
                        <option value="" ${sel(d.bentuk_sediaan,'')}>Pilih Kelas</option>
                        <option value="A" ${sel(d.bentuk_sediaan,'A')}>Kelas A</option>
                        <option value="B" ${sel(d.bentuk_sediaan,'B')}>Kelas B</option>
                        <option value="C" ${sel(d.bentuk_sediaan,'C')}>Kelas C</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" class="form-control" data-field="jumlah" min="1" value="${esc(d.jumlah)}">
                </div>
            </div>`;

        // ── 23. Kosmetik ──
        sf['Kosmetik'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" data-field="nama_produk" placeholder="Contoh: Facial Wash" value="${esc(d.nama_produk)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Scarlett" value="${esc(d.merek)}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. Izin Edar (BPOM)</label>
                    <input type="text" class="form-control" data-field="no_bpom" placeholder="Contoh: NA18211204238" value="${esc(d.no_bpom)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Kadaluwarsa</label>
                    <input type="date" class="form-control" data-field="tanggal_kadaluwarsa" value="${esc(d.tanggal_kadaluwarsa)}">
                </div>
            </div>`;

        // ── 24. Obat-Obatan ──
        sf['Obat-Obatan'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Obat</label>
                    <input type="text" class="form-control" data-field="nama_obat" placeholder="Contoh: Paracetamol" value="${esc(d.nama_obat)}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Panadol" value="${esc(d.merek)}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Bentuk Sediaan</label>
                    <select class="form-select" data-field="bentuk_sediaan">
                        <option value="" ${sel(d.bentuk_sediaan,'')}>Pilih Bentuk</option>
                        <option value="Tablet" ${sel(d.bentuk_sediaan,'Tablet')}>Tablet</option>
                        <option value="Kapsul" ${sel(d.bentuk_sediaan,'Kapsul')}>Kapsul</option>
                        <option value="Sirup" ${sel(d.bentuk_sediaan,'Sirup')}>Sirup</option>
                        <option value="Lainnya" ${sel(d.bentuk_sediaan,'Lainnya')}>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" class="form-control" data-field="jumlah" min="1" value="${esc(d.jumlah)}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Satuan</label>
                    <select class="form-select" data-field="id_satuan">${buildSatuanOptions(d.id_satuan)}</select>
                </div>
            </div>`;

        // ── Return logic ──
        if (sf[namaBarang]) return sf[namaBarang];
        if (!namaBarang) return '<div class="text-center text-muted p-3">Pilih jenis barang untuk menampilkan detail isian.</div>';
        return defaultFieldsHTML(d);
    }

    // ═══════════════════════════════════════════════════════════════════
    // NO BA CACAH
    // ═══════════════════════════════════════════════════════════════════
    document.getElementById('createPencacahanForm').addEventListener('submit', function () {
        const nomor = document.getElementById('no_ba_cacah_nomor').value.trim();
        const tgl = document.getElementById('tanggal_ba_cacah').value;
        if (nomor && tgl) {
            const year = new Date(tgl).getFullYear();
            document.getElementById('no_ba_cacah').value = `BA-${nomor}/CACAH/KBC.010202/${year}`;
        }
    });

    // ═══════════════════════════════════════════════════════════════════
    // SBP SEARCH MODAL
    // ═══════════════════════════════════════════════════════════════════
    function fetchSbp(url) {
        document.getElementById('sbpLoadingIndicator').classList.remove('d-none');
        document.getElementById('sbpErrorAlert').classList.add('d-none');
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.ok ? response.json() : Promise.reject('Gagal'))
            .then(data => {
                const tbody = document.getElementById('sbpTableBody');
                tbody.innerHTML = '';
                if (data.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Data tidak ditemukan.</td></tr>';
                } else {
                    data.data.forEach(sbp => {
                        const tr = document.createElement('tr');
                        if (sbp.pencacahan_exists) tr.classList.add('row-dicacah');
                        tr.innerHTML = `
                            <td class="text-center"><input class="form-check-input sbp-checkbox" type="checkbox" value="${sbp.id}" ${selectedSbpIds.has(sbp.id.toString()) ? 'checked' : ''} ${sbp.pencacahan_exists ? 'disabled' : ''} data-nomor-sbp="${esc(sbp.nomor_sbp)}" data-tanggal-sbp="${sbp.tanggal_sbp || ''}" data-jenis-barang="${esc(sbp.jenis_barang)}" data-uraian-barang="${esc(sbp.uraian_barang)}"></td>
                            <td>${esc(sbp.nomor_sbp) || '-'}</td>
                            <td>${formatTanggal(sbp.tanggal_sbp)}</td>
                            <td><span class="badge bg-${sbp.pencacahan_exists ? 'success' : 'secondary'}">${sbp.pencacahan_exists ? 'Sudah dicacah' : 'Belum dicacah'}</span></td>`;
                        tbody.appendChild(tr);
                    });
                }
                document.getElementById('sbpPagination').innerHTML = data.pagination;
            })
            .catch(() => document.getElementById('sbpErrorAlert').classList.remove('d-none'))
            .finally(() => document.getElementById('sbpLoadingIndicator').classList.add('d-none'));
    }

    let searchTimeout;
    document.getElementById('sbpSearchInput').addEventListener('keyup', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => fetchSbp(`{{ route('pencacahan.searchSbp') }}?search=${encodeURIComponent(e.target.value)}`), 300);
    });

    document.getElementById('sbpPagination').addEventListener('click', (e) => {
        if (e.target.closest('a.page-link')) {
            e.preventDefault();
            fetchSbp(e.target.closest('a.page-link').href);
        }
    });

    sbpModalElement.addEventListener('show.coreui.modal', () => fetchSbp(`{{ route('pencacahan.searchSbp') }}`));

    document.getElementById('selectSbpButton').addEventListener('click', () => {
        document.querySelectorAll('#sbpTableBody .sbp-checkbox:checked').forEach(cb => {
            if (!selectedSbpIds.has(cb.value)) {
                addSbpRow(cb.dataset, cb.value);
                selectedSbpIds.add(cb.value);
            }
        });
        coreui.Modal.getInstance(sbpModalElement).hide();
    });

    // ═══════════════════════════════════════════════════════════════════
    // SELECTED SBP TABLE
    // ═══════════════════════════════════════════════════════════════════
    function addSbpRow(dataset, sbpId) {
        const tbody = document.getElementById('selectedSbpTableBody');
        const tr = document.createElement('tr');
        tr.id = `selected-row-${sbpId}`;
        tr.innerHTML = `
            <td>${esc(dataset.nomorSbp)}</td>
            <td>${formatTanggal(dataset.tanggalSbp)}</td>
            <td class="text-center"><span class="badge bg-secondary" id="status-detail-${sbpId}">Belum Diisi</span></td>
            <td class="text-center"><span class="badge bg-secondary" id="status-foto-${sbpId}">Belum Diunggah</span></td>
            <td class="text-center">
                <button type="button" class="btn btn-info btn-sm text-white btn-detail-sbp" data-sbp-id="${sbpId}" data-nomor-sbp="${esc(dataset.nomorSbp)}" data-tanggal-sbp="${dataset.tanggalSbp}" data-jenis-barang="${esc(dataset.jenisBarang)}" data-uraian-barang="${esc(dataset.uraianBarang)}"><i class="cil-search me-1"></i> Detail</button>
                <button type="button" class="btn btn-danger btn-sm text-white btn-hapus-sbp" data-sbp-id="${sbpId}"><i class="cil-trash"></i></button>
            </td>`;
        tbody.appendChild(tr);
        const hiddenDiv = document.getElementById('hiddenSbpInputs');
        hiddenDiv.insertAdjacentHTML('beforeend', `<input type="hidden" name="id_sbp[]" id="hidden-input-${sbpId}" value="${sbpId}">`);
        hiddenDiv.insertAdjacentHTML('beforeend', `<input type="hidden" name="detail_barang_json[${sbpId}]" id="hidden-barang-json-${sbpId}">`);
    }

    // ═══════════════════════════════════════════════════════════════════
    // TABLE CLICK HANDLER
    // ═══════════════════════════════════════════════════════════════════
    document.getElementById('selectedSbpTableBody').addEventListener('click', e => {
        const sbpId = e.target.closest('[data-sbp-id]')?.dataset.sbpId;
        if (!sbpId) return;

        if (e.target.closest('.btn-hapus-sbp')) {
            document.getElementById(`selected-row-${sbpId}`)?.remove();
            document.getElementById(`hidden-input-${sbpId}`)?.remove();
            document.getElementById(`hidden-barang-json-${sbpId}`)?.remove();
            document.getElementById(`foto_barang_${sbpId}`)?.remove();
            selectedSbpIds.delete(sbpId);

        } else if (e.target.closest('.btn-detail-sbp')) {
            const ds = e.target.closest('.btn-detail-sbp').dataset;
            detailSbpModalElement.dataset.currentSbpId = sbpId;
            document.getElementById('detail-nomor-sbp').value = ds.nomorSbp;
            document.getElementById('detail-tanggal-sbp').value = formatTanggal(ds.tanggalSbp);
            document.getElementById('detail-jenis-barang').value = ds.jenisBarang;
            document.getElementById('detail-uraian-barang').value = ds.uraianBarang;

            // Load repeater
            barangContainer.innerHTML = '';
            const jsonStr = document.getElementById(`hidden-barang-json-${sbpId}`)?.value;
            if (jsonStr) {
                try {
                    const arr = JSON.parse(jsonStr);
                    if (Array.isArray(arr)) arr.forEach(item => addRepeaterItem(item));
                } catch (err) { console.error('Parse error:', err); }
            }
            updateEmptyMessage();
            renumberBarang();

            // Load foto preview
            const fileInput = document.getElementById(`foto_barang_${sbpId}`);
            const preview = document.getElementById('foto_preview_modal');
            const placeholder = document.querySelector('.foto-placeholder-modal');
            const removeBtn = document.getElementById('btn-remove-foto-modal');
            if (fileInput && fileInput.files[0]) {
                preview.src = URL.createObjectURL(fileInput.files[0]);
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
                removeBtn.classList.remove('d-none');
            } else {
                preview.src = '';
                preview.classList.add('d-none');
                placeholder.classList.remove('d-none');
                removeBtn.classList.add('d-none');
            }
            detailSbpModal.show();
        }
    });

    // ═══════════════════════════════════════════════════════════════════
    // REPEATER
    // ═══════════════════════════════════════════════════════════════════
    // Auto-calc total batang (event delegation)
    barangContainer.addEventListener('input', function (e) {
        if (e.target.matches('[data-field="jumlah_bungkus"]') || e.target.matches('[data-field="jumlah_batang"]')) {
            const card = e.target.closest('.barang-item');
            if (!card) return;
            const bungkus = parseInt(card.querySelector('[data-field="jumlah_bungkus"]')?.value, 10) || 0;
            const batang = parseInt(card.querySelector('[data-field="jumlah_batang"]')?.value, 10) || 0;
            const total = card.querySelector('[data-field="total_batang"]');
            if (total) total.value = bungkus * batang;
        }
    });

    function addRepeaterItem(data = {}) {
        const item = document.createElement('div');
        item.className = 'barang-item card mb-3 border';
        item.innerHTML = `
            <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                <span class="fw-semibold barang-number">Barang</span>
                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-barang" title="Hapus"><i class="cil-trash"></i></button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Jenis Barang</label>
                    <select class="form-select input-jenis-barang">${buildJenisBarangOptions()}</select>
                </div>
                <div class="conditional-fields-container">
                    ${data.id_jenis_barang ? getConditionalFieldsHTML(jenisBarangOptions.find(j => j.id == data.id_jenis_barang)?.nama_barang, data) : '<div class="text-center text-muted p-3">Pilih jenis barang untuk menampilkan detail isian.</div>'}
                </div>
            </div>`;

        barangContainer.appendChild(item);

        const jenisSelect = item.querySelector('.input-jenis-barang');
        if (data.id_jenis_barang) jenisSelect.value = data.id_jenis_barang;

        jenisSelect.addEventListener('change', (e) => {
            const nama = e.target.options[e.target.selectedIndex].dataset.nama;
            item.querySelector('.conditional-fields-container').innerHTML = getConditionalFieldsHTML(nama);
        });

        updateEmptyMessage();
        renumberBarang();
    }

    btnTambah.addEventListener('click', () => {
        addRepeaterItem();
        barangContainer.lastChild.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });

    barangContainer.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-hapus-barang');
        if (!btn) return;
        btn.closest('.barang-item').remove();
        renumberBarang();
        updateEmptyMessage();
    });

    function getBarangData() {
        const data = [];
        barangContainer.querySelectorAll('.barang-item').forEach((item, i) => {
            const jenis = item.querySelector('.input-jenis-barang');
            if (!jenis.value) return;
            const entry = { urutan: i + 1, id_jenis_barang: jenis.value };
            item.querySelectorAll('.conditional-fields-container [data-field]').forEach(f => {
                entry[f.dataset.field] = f.value.trim();
            });
            data.push(entry);
        });
        return data;
    }

    // ═══════════════════════════════════════════════════════════════════
    // SIMPAN DETAIL
    // ═══════════════════════════════════════════════════════════════════
    document.getElementById('saveSbpDetailButton').addEventListener('click', () => {
        const sbpId = detailSbpModalElement.dataset.currentSbpId;
        const barangData = getBarangData();
        document.getElementById(`hidden-barang-json-${sbpId}`).value = JSON.stringify(barangData);

        const statusDetail = document.getElementById(`status-detail-${sbpId}`);
        if (barangData.length > 0 && barangData.some(d => d.id_jenis_barang)) {
            statusDetail.textContent = `${barangData.length} barang`;
            statusDetail.className = 'badge bg-success';
        } else {
            statusDetail.textContent = 'Belum Diisi';
            statusDetail.className = 'badge bg-secondary';
        }

        const modalFileInput = document.getElementById('foto_barang_modal');
        let fileInput = document.getElementById(`foto_barang_${sbpId}`);
        if (!fileInput) {
            fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.name = `foto_barang[${sbpId}]`;
            fileInput.id = `foto_barang_${sbpId}`;
            document.getElementById('hiddenFileInputs').appendChild(fileInput);
        }
        if (modalFileInput.files.length > 0) fileInput.files = modalFileInput.files;

        const statusFoto = document.getElementById(`status-foto-${sbpId}`);
        statusFoto.textContent = fileInput.files.length > 0 ? 'Siap Diunggah' : 'Belum Diunggah';
        statusFoto.className = `badge bg-${fileInput.files.length > 0 ? 'success' : 'secondary'}`;

        detailSbpModal.hide();
    });

    // ═══════════════════════════════════════════════════════════════════
    // FOTO HANDLERS
    // ═══════════════════════════════════════════════════════════════════
    document.getElementById('foto-upload-modal-trigger').addEventListener('click', () => document.getElementById('foto_barang_modal').click());

    document.getElementById('foto_barang_modal').addEventListener('change', function () {
        const preview = document.getElementById('foto_preview_modal');
        const placeholder = document.querySelector('.foto-placeholder-modal');
        const removeBtn = document.getElementById('btn-remove-foto-modal');
        if (this.files && this.files[0]) {
            preview.src = URL.createObjectURL(this.files[0]);
            preview.classList.remove('d-none');
            placeholder.classList.add('d-none');
            removeBtn.classList.remove('d-none');
        } else {
            preview.src = '';
            preview.classList.add('d-none');
            placeholder.classList.remove('d-none');
            removeBtn.classList.add('d-none');
        }
    });

    document.getElementById('btn-remove-foto-modal').addEventListener('click', () => {
        const f = document.getElementById('foto_barang_modal');
        f.value = '';
        f.dispatchEvent(new Event('change'));
    });

    // ═══════════════════════════════════════════════════════════════════
    // RESTORE OLD INPUT
    // ═══════════════════════════════════════════════════════════════════
    selectedSbpIds.forEach(sbpId => {
        const jsonStr = document.getElementById(`hidden-barang-json-${sbpId}`)?.value;
        if (jsonStr) {
            try {
                const arr = JSON.parse(jsonStr);
                const st = document.getElementById(`status-detail-${sbpId}`);
                if (st && Array.isArray(arr) && arr.length > 0 && arr.some(d => d.id_jenis_barang)) {
                    st.textContent = `${arr.length} barang`;
                    st.className = 'badge bg-success';
                }
            } catch (e) { console.error('Restore error:', e); }
        }
    });
});
</script>
@endpush