@extends('layouts.app')

@section('content')
<div class="container-lg">
    <form action="{{ route('pencacahan.update', $pencacahan->id) }}" method="POST" id="editPencacahanForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0"><i class="cil-pencil me-2"></i>Edit Pencacahan</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm">
                    <h6 class="alert-heading"><i class="cil-warning me-2"></i>Terjadi Kesalahan</h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Card Penomoran --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="card-title mb-0"><i class="cil-notes me-2"></i>Penomoran</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_ba_cacah_nomor" class="form-label">Nomor BA Cacah</label>
                                    @php
                                        $no_ba_cacah_val = old('no_ba_cacah', $pencacahan->no_ba_cacah);
                                        $no_ba_cacah_nomor = '';
                                        if ($no_ba_cacah_val) {
                                            preg_match('/^BA-(\d+)/i', $no_ba_cacah_val, $matches);
                                            if (isset($matches[1])) {
                                                $no_ba_cacah_nomor = $matches[1];
                                            }
                                        }
                                    @endphp
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="cil-barcode"></i></span>
                                        <input type="text" class="form-control" id="no_ba_cacah_nomor" placeholder="Masukkan hanya angka" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ $no_ba_cacah_nomor }}">
                                    </div>
                                    <input type="hidden" name="no_ba_cacah" id="no_ba_cacah" value="{{ $no_ba_cacah_val }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_ba_cacah" class="form-label">Tanggal BA Cacah</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="cil-calendar"></i></span>
                                        <input type="date" class="form-control" id="tanggal_ba_cacah" name="tanggal_ba_cacah" value="{{ old('tanggal_ba_cacah', $pencacahan->tanggal_ba_cacah->format('Y-m-d')) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_surat_tugas_pencacahan" class="form-label">Nomor Surat Tugas Pencacahan</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="cil-description"></i></span>
                                        <input type="text" class="form-control" id="no_surat_tugas_pencacahan" name="no_surat_tugas_pencacahan" placeholder="Contoh: ST-123/KBC.010202/2024" value="{{ old('no_surat_tugas_pencacahan', $pencacahan->no_surat_tugas_pencacahan) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_surat_tugas_pencacahan" class="form-label">Tanggal Surat Tugas Pencacahan</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="cil-calendar"></i></span>
                                        <input type="date" class="form-control" id="tanggal_surat_tugas_pencacahan" name="tanggal_surat_tugas_pencacahan" value="{{ old('tanggal_surat_tugas_pencacahan', $pencacahan->tanggal_surat_tugas_pencacahan ? $pencacahan->tanggal_surat_tugas_pencacahan->format('Y-m-d') : '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Detail Cacah & Petugas --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="card-title mb-0"><i class="cil-settings me-2"></i>Detail & Petugas</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lokasi_cacah" class="form-label">Lokasi Cacah</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="cil-location-pin"></i></span>
                                        <input type="text" class="form-control" id="lokasi_cacah" name="lokasi_cacah" list="lokasiCacahOptions" value="{{ old('lokasi_cacah', $pencacahan->lokasi_cacah) }}">
                                        <datalist id="lokasiCacahOptions">
                                            <option value="KPPBC TMP C Banda Aceh">
                                        </datalist>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="giat" class="form-label">Giat</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="cil-thumb-up"></i></span>
                                        <input type="text" class="form-control" id="giat" name="giat" list="giatOptions" value="{{ old('giat', $pencacahan->giat) }}">
                                        <datalist id="giatOptions">
                                            <option value="Bandara">
                                            <option value="Operasi Pasar">
                                        </datalist>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="id_petugas_1" class="form-label">Petugas 1</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="cil-user"></i></span>
                                        <select id="id_petugas_1" class="form-select" name="id_petugas_1" required>
                                            <option value="" selected disabled>Pilih Petugas 1</option>
                                            @foreach($petugasData as $petugas)
                                            <option value="{{ $petugas->id }}" {{ old('id_petugas_1', $pencacahan->id_petugas_1) == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
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
                                        <select id="id_petugas_2" class="form-select" name="id_petugas_2">
                                            <option value="">Pilih Petugas 2 (Opsional)</option>
                                            @foreach($petugasData as $petugas)
                                            <option value="{{ $petugas->id }}" {{ old('id_petugas_2', $pencacahan->id_petugas_2) == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Dokumen SBP Terkait --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0"><i class="cil-link-alt me-2"></i>Dokumen SBP Terkait</h6>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary mb-3" data-coreui-toggle="modal" data-coreui-target="#sbpModal">
                            <i class="cil-file me-2"></i> Pilih Dokumen SBP
                        </button>

                        <div class="table-responsive">
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
                                    @foreach($sbpDataForView as $sbp)
                                        <tr id="selected-row-{{ $sbp->id }}">
                                            <td>{{ $sbp->nomor_sbp }}</td>
                                            <td>{{ \Carbon\Carbon::parse($sbp->tanggal_sbp)->translatedFormat('d F Y') }}</td>
                                            @php
                                                $detailJson = old("detail_barang_json.{$sbp->id}", $sbp->details_json);
                                                $details = $detailJson ? json_decode($detailJson, true) : [];
                                                $hasDetails = !empty($details) && count($details) > 0;
                                                
                                                $hasFile = old("has_file.{$sbp->id}", $sbp->has_file) == '1';
                                                $hasFileError = $errors->has("foto_barang.{$sbp->id}");
                                            @endphp
                                            <td class="text-center">
                                                <span class="badge {{ $hasDetails ? 'bg-success' : 'bg-secondary' }}" id="status-detail-{{$sbp->id}}">
                                                    {{ $hasDetails ? count($details) . ' barang' : 'Belum Diisi' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge {{ $hasFileError ? 'bg-danger' : ($hasFile ? 'bg-success' : 'bg-secondary') }}" id="status-foto-{{$sbp->id}}">
                                                    @if($hasFileError)
                                                        File Error
                                                    @elseif($hasFile)
                                                        Ada
                                                    @else
                                                        Kosong
                                                    @endif
                                                </span>
                                            </td>
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
                                </tbody>
                            </table>
                        </div>
                        <div id="hiddenInputsContainer">
                            @foreach($sbpDataForView as $sbp)
                                <div id="hidden-inputs-for-{{ $sbp->id }}">
                                    <input type="hidden" name="id_sbp[]" value="{{ $sbp->id }}">
                                    <input type="hidden" name="detail_barang_json[{{$sbp->id}}]" id="hidden-barang-json-{{$sbp->id}}" value='{{ old("detail_barang_json.{$sbp->id}", $sbp->details_json) }}'>
                                    <input type="file" name="foto_barang[{{$sbp->id}}]" id="hidden-file-input-{{$sbp->id}}" class="d-none" accept="image/*">
                                    <input type="hidden" name="has_file[{{$sbp->id}}]" id="has-file-hidden-{{$sbp->id}}" value="{{ old("has_file.{$sbp->id}", $sbp->has_file) }}">
                                    <input type="hidden" name="remove_foto[{{$sbp->id}}]" id="remove-foto-hidden-{{$sbp->id}}" value="0">
                                    {{-- Simpan URL foto lama untuk preview --}}
                                    <input type="hidden" id="existing-photo-url-{{$sbp->id}}" value="{{ $sbp->photo_url ?? '' }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end bg-light">
                <a href="{{ route('pencacahan.index') }}" class="btn btn-secondary"><i class="cil-x-circle me-2"></i>Batal</a>
                <button type="submit" class="btn btn-warning"><i class="cil-save me-2"></i>Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>

@include('pencacahan.partials._modal_sbp_selection')
@include('pencacahan.partials._modal_sbp_detail')
@endsection

@push('styles')
<style>
    .foto-upload-wrapper { position: relative; border: 2px dashed #c4c9d0; border-radius: .25rem; padding: 1.5rem; background-color: #f8f9fa; min-height: 200px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background-color 0.2s, border-color 0.2s; }
    .foto-upload-wrapper:hover { background-color: #e9ecef; }
    .foto-upload-wrapper.dragover { background-color: #e7f1ff; border-color: #0d6efd; }
    .foto-upload-wrapper.compressing { opacity: .5; pointer-events: none; }
    .foto-upload-wrapper.compressing::after {
        content: 'Mengompres foto...';
        position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
        font-size: .85rem; font-weight: 600; color: #0d6efd;
        background: rgba(255,255,255,.9); padding: .35rem .75rem; border-radius: .25rem;
        white-space: nowrap;
    }
    #foto_preview_modal { max-height: 250px; object-fit: contain; }
    .row-dicacah { background-color: #e9ecef !important; color: #6c757d; cursor: not-allowed; }
    .row-dicacah:hover { background-color: #e0e5e9 !important; }
    #sbpPagination .pagination { cursor: pointer; }
    #selectedSbpTable .btn-sm { padding: 0.2rem 0.5rem; font-size: 0.8rem; }
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
    const selectedSbpIds = new Set(@json($sbpDataForView->pluck('id')).map(id => id.toString()));
    const jenisBarangOptions = @json($jenisBarangData);
    const tarifCukaiOptions = @json($tarifCukaiData);
    const barangContainer = document.getElementById('barangItemsContainer');
    const emptyMessage = document.getElementById('emptyBarangMessage');
    const btnTambah = document.getElementById('btnTambahBarang');
    const hiddenInputsContainer = document.getElementById('hiddenInputsContainer');
    const csrfToken = '{{ csrf_token() }}';
    const currentPencacahanId = {{ $pencacahan->id }};

    // Pending selections untuk persist checkbox antar halaman pagination modal
    const pendingSelections = new Map();
    // SBP yang sudah terpilih sebelumnya tapi di-uncheck lagi di modal (batal pilih), belum dikonfirmasi
    const pendingRemovals = new Set();

    // ═══════════════════════════════════════════════════════════════════
    // UTILITY
    // ═══════════════════════════════════════════════════════════════════
    function formatTanggal(raw) {
        if (!raw) return '-';
        const d = new Date(raw);
        return isNaN(d.getTime()) ? '-' : d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    }

    function esc(val) {
        if (val === null || val === undefined) return '';
        return String(val).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    function buildJenisBarangOptions() {
        return '<option value="" selected disabled>Pilih Jenis Barang</option>' +
            jenisBarangOptions.map((jb, i) => `<option value="${jb.id}">${i + 1}. ${esc(jb.nama_barang)}</option>`).join('');
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
    // DYNAMIC FORM FIELDS
    // ═══════════════════════════════════════════════════════════════════
    async function loadConditionalFields(container, jenisBarangId, data = {}) {
        if (!jenisBarangId) {
            container.innerHTML = '<div class="text-center text-muted p-3">Pilih jenis barang untuk menampilkan detail isian.</div>';
            return;
        }

        container.innerHTML = `
            <div class="d-flex justify-content-center align-items-center p-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span class="ms-2">Memuat...</span>
            </div>`;

        try {
            const formData = new FormData();
            formData.append('id_jenis_barang', jenisBarangId);
            formData.append('_token', csrfToken);
            formData.append('data', JSON.stringify(data));

            const response = await fetch('{{ route("pencacahan.getBarangFields") }}', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!response.ok) throw new Error('Network response was not ok');
            const html = await response.text();
            container.innerHTML = html;
            NegaraAsalHelper.init(container);

        } catch (error) {
            console.error('Error fetching fields:', error);
            container.innerHTML = '<div class="alert alert-danger">Gagal memuat detail isian. Silakan coba lagi.</div>';
        }
    }

    // ═══════════════════════════════════════════════════════════════════
    // NO BA CACAH
    // ═══════════════════════════════════════════════════════════════════
    document.getElementById('editPencacahanForm').addEventListener('submit', function () {
        const nomor = document.getElementById('no_ba_cacah_nomor').value.trim();
        const tgl = document.getElementById('tanggal_ba_cacah').value;
        if (nomor && tgl) {
            const year = new Date(tgl).getFullYear();
            document.getElementById('no_ba_cacah').value = `BA-${nomor}/KBC.010202/Cacah/${year}`;
        }
    });

    // ═══════════════════════════════════════════════════════════════════
    // SBP SEARCH MODAL (mode edit: kirim pencacahan_id)
    // ═══════════════════════════════════════════════════════════════════
    function getSearchUrl(searchTerm = '') {
        const url = new URL('{{ route("pencacahan.searchSbp") }}', window.location.origin);
        url.searchParams.append('pencacahan_id', currentPencacahanId);
        if (searchTerm) {
            url.searchParams.append('search', searchTerm);
        }
        return url.toString();
    }

    function fetchSbp(url) {
        document.getElementById('sbpLoadingIndicator').classList.remove('d-none');
        document.getElementById('sbpErrorAlert').classList.add('d-none');
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.ok ? response.json() : Promise.reject('Gagal'))
            .then(data => {
                const tbody = document.getElementById('sbpTableBody');
                tbody.innerHTML = '';
                if (data.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted p-4"><div class="text-center text-muted p-4"><i class="cil-ban" style="font-size: 2.5rem;"></i><p class="mb-0 mt-2 fw-bold">Data tidak ditemukan</p></div></td></tr>';
                } else {
                    data.data.forEach(sbp => {
                        const tr = document.createElement('tr');
                        const sbpIdStr = sbp.id.toString();
                        const isChecked = (selectedSbpIds.has(sbpIdStr) && !pendingRemovals.has(sbpIdStr)) || pendingSelections.has(sbpIdStr);
                        if (sbp.is_disabled) tr.classList.add('row-dicacah');
                        tr.innerHTML = `
                            <td class="text-center"><input class="form-check-input sbp-checkbox" type="checkbox" value="${sbp.id}" ${isChecked ? 'checked' : ''} ${sbp.is_disabled ? 'disabled' : ''} data-nomor-sbp="${esc(sbp.nomor_sbp)}" data-tanggal-sbp="${sbp.tanggal_sbp || ''}" data-jenis-barang="${esc(sbp.jenis_barang)}" data-uraian-barang="${esc(sbp.uraian_barang)}"></td>
                            <td>${esc(sbp.nomor_sbp) || '-'}</td>
                            <td>${formatTanggal(sbp.tanggal_sbp)}</td>
                            <td><span class="badge bg-${sbp.is_disabled ? 'success' : 'secondary'}">${sbp.is_disabled ? 'Sudah dicacah' : 'Belum dicacah'}</span></td>`;
                        tbody.appendChild(tr);
                    });
                }
                document.getElementById('sbpPagination').innerHTML = data.pagination;
            })
            .catch(() => document.getElementById('sbpErrorAlert').classList.remove('d-none'))
            .finally(() => document.getElementById('sbpLoadingIndicator').classList.add('d-none'));
    }

    // Persist checkbox saat pindah halaman pagination
    document.getElementById('sbpTableBody').addEventListener('change', (e) => {
        const cb = e.target.closest('.sbp-checkbox');
        if (!cb || cb.disabled) return;

        const sbpIdStr = cb.value.toString();
        if (cb.checked) {
            pendingRemovals.delete(sbpIdStr);
            if (!selectedSbpIds.has(sbpIdStr)) {
                pendingSelections.set(sbpIdStr, {
                    nomorSbp: cb.dataset.nomorSbp,
                    tanggalSbp: cb.dataset.tanggalSbp,
                    jenisBarang: cb.dataset.jenisBarang,
                    uraianBarang: cb.dataset.uraianBarang,
                });
            }
        } else {
            pendingSelections.delete(sbpIdStr);
            // SBP yang sudah confirmed lalu di-uncheck di modal: tandai untuk dihapus saat "Pilih" diklik
            if (selectedSbpIds.has(sbpIdStr)) {
                pendingRemovals.add(sbpIdStr);
            }
        }
    });

    let searchTimeout;
    document.getElementById('sbpSearchInput').addEventListener('keyup', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => fetchSbp(getSearchUrl(e.target.value)), 300);
    });

    document.getElementById('sbpPagination').addEventListener('click', (e) => {
        if (e.target.closest('a.page-link')) {
            e.preventDefault();
            fetchSbp(e.target.closest('a.page-link').href);
        }
    });

    sbpModalElement.addEventListener('show.coreui.modal', () => {
        pendingSelections.clear();
        pendingRemovals.clear();
        fetchSbp(getSearchUrl());
    });

    document.getElementById('selectSbpButton').addEventListener('click', () => {
        pendingSelections.forEach((dataset, sbpId) => {
            if (!selectedSbpIds.has(sbpId)) {
                addSbpRowAndInputs(dataset, sbpId);
                selectedSbpIds.add(sbpId);
            }
        });
        pendingSelections.clear();

        // Proses SBP yang di-uncheck (batal pilih) di modal
        pendingRemovals.forEach((sbpId) => {
            document.getElementById(`selected-row-${sbpId}`)?.remove();
            document.getElementById(`hidden-inputs-for-${sbpId}`)?.remove();
            selectedSbpIds.delete(sbpId);
        });
        pendingRemovals.clear();

        document.querySelectorAll('#sbpTableBody .sbp-checkbox:checked:not(:disabled)').forEach(cb => {
            const sbpIdStr = cb.value.toString();
            if (!selectedSbpIds.has(sbpIdStr)) {
                addSbpRowAndInputs(cb.dataset, sbpIdStr);
                selectedSbpIds.add(sbpIdStr);
            }
        });

        coreui.Modal.getInstance(sbpModalElement).hide();
    });

    // ═══════════════════════════════════════════════════════════════════
    // MANAGE SBP TABLE & HIDDEN INPUTS
    // ═══════════════════════════════════════════════════════════════════
    function addSbpRowAndInputs(dataset, sbpId) {
        const tbody = document.getElementById('selectedSbpTableBody');
        const tr = document.createElement('tr');
        tr.id = `selected-row-${sbpId}`;
        tr.innerHTML = `
            <td>${esc(dataset.nomorSbp)}</td>
            <td>${formatTanggal(dataset.tanggalSbp)}</td>
            <td class="text-center"><span class="badge bg-secondary" id="status-detail-${sbpId}">Belum Diisi</span></td>
            <td class="text-center"><span class="badge bg-secondary" id="status-foto-${sbpId}">Kosong</span></td>
            <td class="text-center">
                <button type="button" class="btn btn-info btn-sm text-white btn-detail-sbp" data-sbp-id="${sbpId}" data-nomor-sbp="${esc(dataset.nomorSbp)}" data-tanggal-sbp="${dataset.tanggalSbp}" data-jenis-barang="${esc(dataset.jenisBarang)}" data-uraian-barang="${esc(dataset.uraianBarang)}"><i class="cil-search me-1"></i> Detail</button>
                <button type="button" class="btn btn-danger btn-sm text-white btn-hapus-sbp" data-sbp-id="${sbpId}"><i class="cil-trash"></i></button>
            </td>`;
        tbody.appendChild(tr);

        const div = document.createElement('div');
        div.id = `hidden-inputs-for-${sbpId}`;
        div.innerHTML = `
            <input type="hidden" name="id_sbp[]" value="${sbpId}">
            <input type="hidden" name="detail_barang_json[${sbpId}]" id="hidden-barang-json-${sbpId}" value="[]">
            <input type="file" name="foto_barang[${sbpId}]" id="hidden-file-input-${sbpId}" class="d-none" accept="image/*">
            <input type="hidden" name="has_file[${sbpId}]" id="has-file-hidden-${sbpId}" value="0">
            <input type="hidden" name="remove_foto[${sbpId}]" id="remove-foto-hidden-${sbpId}" value="0">
            <input type="hidden" id="existing-photo-url-${sbpId}" value="">
        `;
        hiddenInputsContainer.appendChild(div);

        document.getElementById(`hidden-file-input-${sbpId}`).addEventListener('change', onFotoInputChange);
    }

    document.getElementById('selectedSbpTableBody').addEventListener('click', e => {
        const sbpId = e.target.closest('[data-sbp-id]')?.dataset.sbpId;
        if (!sbpId) return;

        if (e.target.closest('.btn-hapus-sbp')) {
            document.getElementById(`selected-row-${sbpId}`)?.remove();
            document.getElementById(`hidden-inputs-for-${sbpId}`)?.remove();
            selectedSbpIds.delete(sbpId);
        } else if (e.target.closest('.btn-detail-sbp')) {
            openDetailModal(e.target.closest('.btn-detail-sbp').dataset);
        }
    });

    // ═══════════════════════════════════════════════════════════════════
    // DETAIL MODAL LOGIC
    // ═══════════════════════════════════════════════════════════════════
    function openDetailModal(dataset) {
        const sbpId = dataset.sbpId;
        detailSbpModalElement.dataset.currentSbpId = sbpId;

        document.getElementById('detail-nomor-sbp').value = dataset.nomorSbp;
        document.getElementById('detail-tanggal-sbp').value = formatTanggal(dataset.tanggalSbp);
        document.getElementById('detail-jenis-barang').value = dataset.jenisBarang;
        document.getElementById('detail-uraian-barang').value = dataset.uraianBarang;

        barangContainer.innerHTML = '';
        const jsonInput = document.getElementById(`hidden-barang-json-${sbpId}`);
        const jsonStr = jsonInput ? jsonInput.value : '[]';
        
        if (jsonStr) {
            try {
                const correctedJsonStr = jsonStr.replace(/&quot;/g, '"');
                const arr = JSON.parse(correctedJsonStr);
                if (Array.isArray(arr)) arr.forEach(item => addRepeaterItem(item));
            } catch (err) { 
                console.error('Parse error on old JSON:', err, 'Original string:', jsonStr); 
            }
        }
        updateEmptyMessage();
        renumberBarang();

        updateFotoPreview(sbpId);
        detailSbpModal.show();
    }

    document.getElementById('saveSbpDetailButton').addEventListener('click', () => {
        const sbpId = detailSbpModalElement.dataset.currentSbpId;
        
        const barangData = getBarangData();
        const jsonInput = document.getElementById(`hidden-barang-json-${sbpId}`);
        if (jsonInput) {
            jsonInput.value = JSON.stringify(barangData);
        }

        const statusDetail = document.getElementById(`status-detail-${sbpId}`);
        if (barangData.length > 0 && barangData.some(d => d.id_jenis_barang)) {
            statusDetail.textContent = `${barangData.length} barang`;
            statusDetail.className = 'badge bg-success';
        } else {
            statusDetail.textContent = 'Belum Diisi';
            statusDetail.className = 'badge bg-secondary';
        }

        detailSbpModal.hide();
    });

    // ═══════════════════════════════════════════════════════════════════
    // REPEATER (BARANG ITEMS)
    // ═══════════════════════════════════════════════════════════════════
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

    // Jumlah Batang/Bks (Hasil Tembakau): default 20 batang per bungkus jika ditinggal kosong.
    barangContainer.addEventListener('focusout', function (e) {
        if (e.target.matches('[data-field="jumlah_batang"]') && e.target.value.trim() === '') {
            e.target.value = 20;
            e.target.dispatchEvent(new Event('input', { bubbles: true }));
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
                    <div class="text-center text-muted p-3">Pilih jenis barang untuk menampilkan detail isian.</div>
                </div>
            </div>`;

        barangContainer.appendChild(item);

        const jenisSelect = item.querySelector('.input-jenis-barang');
        const fieldsContainer = item.querySelector('.conditional-fields-container');

        if (data.id_jenis_barang) {
            jenisSelect.value = data.id_jenis_barang;
            loadConditionalFields(fieldsContainer, data.id_jenis_barang, data);
        }

        jenisSelect.addEventListener('change', (e) => {
            loadConditionalFields(fieldsContainer, e.target.value);
        });

        updateEmptyMessage();
        renumberBarang();
    }

    btnTambah.addEventListener('click', () => {
        addRepeaterItem();
        barangContainer.lastChild.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });

    barangContainer.addEventListener('click', (e) => {
        if (e.target.closest('.btn-hapus-barang')) {
            e.target.closest('.barang-item').remove();
            renumberBarang();
            updateEmptyMessage();
        }
    });

    function getBarangData() {
        const data = [];
        barangContainer.querySelectorAll('.barang-item').forEach((item, i) => {
            const jenis = item.querySelector('.input-jenis-barang');
            if (!jenis || !jenis.value) return;

            const entry = {
                urutan: i + 1,
                id_jenis_barang: jenis.value
            };

            item.querySelectorAll('.conditional-fields-container [data-field]').forEach(f => {
                const fieldName = f.dataset.field;
                if (fieldName && typeof fieldName === 'string' && fieldName.trim() !== '') {
                    const fieldValue = f.value;
                    entry[fieldName.trim()] = (fieldValue != null) ? fieldValue.toString().trim() : '';
                }
            });

            // Jaring pengaman: pastikan jumlah_batang & total_batang konsisten walau field belum sempat di-blur.
            if (Object.prototype.hasOwnProperty.call(entry, 'jumlah_batang')) {
                const batang = entry.jumlah_batang === '' ? 20 : (parseInt(entry.jumlah_batang, 10) || 20);
                const bungkus = parseInt(entry.jumlah_bungkus, 10) || 0;
                entry.jumlah_batang = String(batang);
                entry.total_batang = String(bungkus * batang);
            }

            // Jaring pengaman: field berikut wajib punya nilai, kalau tidak diisi user pakai default.
            if (Object.prototype.hasOwnProperty.call(entry, 'id_ref_tarif_cukai') && !entry.id_ref_tarif_cukai) {
                const defaultTarif = tarifCukaiOptions.find(t => t.jenis === 'SPM' && t.golongan === 'I');
                if (defaultTarif) entry.id_ref_tarif_cukai = String(defaultTarif.id);
            }
            if (Object.prototype.hasOwnProperty.call(entry, 'kondisi_barang') && !entry.kondisi_barang) {
                entry.kondisi_barang = 'Baru';
            }
            if (Object.prototype.hasOwnProperty.call(entry, 'negara_asal') && !entry.negara_asal) {
                entry.negara_asal = 'Indonesia';
            }

            data.push(entry);
        });
        return data;
    }

    // ═══════════════════════════════════════════════════════════════════
    // FOTO HANDLING (DIPERBAIKI UNTUK EDIT)
    // ═══════════════════════════════════════════════════════════════════
    const fotoUploadWrapper = document.getElementById('foto-upload-modal-trigger');
    const FOTO_COMPRESS_OPTIONS = { maxWidth: 1920, maxHeight: 1920, quality: 0.75 };

    // Kompres gambar di browser (canvas) sebelum diunggah agar ukuran file lebih kecil.
    function compressImage(file, opts = FOTO_COMPRESS_OPTIONS) {
        return new Promise((resolve) => {
            if (!file.type.startsWith('image/') || file.type === 'image/gif') {
                resolve(file);
                return;
            }
            const objectUrl = URL.createObjectURL(file);
            const img = new Image();
            img.onload = () => {
                const ratio = Math.min(1, opts.maxWidth / img.width, opts.maxHeight / img.height);
                const width = Math.round(img.width * ratio);
                const height = Math.round(img.height * ratio);

                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                canvas.getContext('2d').drawImage(img, 0, 0, width, height);

                canvas.toBlob((blob) => {
                    URL.revokeObjectURL(objectUrl);
                    if (!blob || blob.size >= file.size) {
                        resolve(file);
                        return;
                    }
                    const newName = file.name.replace(/\.[^./\\]+$/, '') + '.jpg';
                    resolve(new File([blob], newName, { type: 'image/jpeg', lastModified: Date.now() }));
                }, 'image/jpeg', opts.quality);
            };
            img.onerror = () => {
                URL.revokeObjectURL(objectUrl);
                resolve(file);
            };
            img.src = objectUrl;
        });
    }

    // Kompres lalu pasang file ke input, kemudian trigger 'change' agar preview & status ter-update.
    async function setCompressedFile(input, file) {
        fotoUploadWrapper.classList.add('compressing');
        try {
            const compressed = await compressImage(file);
            const dt = new DataTransfer();
            dt.items.add(compressed);
            input.dataset.skipCompress = '1';
            input.files = dt.files;
            input.dispatchEvent(new Event('change', { bubbles: true }));
        } finally {
            fotoUploadWrapper.classList.remove('compressing');
        }
    }

    // Listener utama pada input file: file dari picker dikompres dulu, file hasil kompresi (re-dispatch) langsung diproses.
    function onFotoInputChange(event) {
        const input = event.target;
        if (input.dataset.skipCompress === '1') {
            delete input.dataset.skipCompress;
            handleFileChange(event);
            return;
        }
        const file = input.files && input.files[0];
        if (!file) {
            handleFileChange(event);
            return;
        }
        setCompressedFile(input, file);
    }

    fotoUploadWrapper.addEventListener('click', () => {
        const sbpId = detailSbpModalElement.dataset.currentSbpId;
        document.getElementById(`hidden-file-input-${sbpId}`)?.click();
    });

    ['dragenter', 'dragover'].forEach(evt => {
        fotoUploadWrapper.addEventListener(evt, (e) => {
            e.preventDefault();
            e.stopPropagation();
            fotoUploadWrapper.classList.add('dragover');
        });
    });

    ['dragleave', 'dragend', 'drop'].forEach(evt => {
        fotoUploadWrapper.addEventListener(evt, (e) => {
            e.preventDefault();
            e.stopPropagation();
            fotoUploadWrapper.classList.remove('dragover');
        });
    });

    fotoUploadWrapper.addEventListener('drop', (e) => {
        const file = e.dataTransfer?.files?.[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) {
            alert('File yang di-drop harus berupa gambar.');
            return;
        }
        const sbpId = detailSbpModalElement.dataset.currentSbpId;
        const input = document.getElementById(`hidden-file-input-${sbpId}`);
        if (input) setCompressedFile(input, file);
    });

    function handleFileChange(event) {
        const sbpId = event.target.id.replace('hidden-file-input-', '');
        const fileInput = event.target;

        if (fileInput.files.length > 0) {
            // Ada file baru dipilih → reset remove flag
            const removeInput = document.getElementById(`remove-foto-hidden-${sbpId}`);
            if (removeInput) removeInput.value = '0';
        }

        updateFotoPreview(sbpId);
        updateFotoStatus(sbpId);
    }

    function updateFotoPreview(sbpId) {
        const fileInput = document.getElementById(`hidden-file-input-${sbpId}`);
        const preview = document.getElementById('foto_preview_modal');
        const placeholder = document.querySelector('.foto-placeholder-modal');
        const removeBtn = document.getElementById('btn-remove-foto-modal');
        const existingUrl = document.getElementById(`existing-photo-url-${sbpId}`)?.value;
        const isMarkedRemoved = document.getElementById(`remove-foto-hidden-${sbpId}`)?.value === '1';

        if (fileInput && fileInput.files && fileInput.files[0]) {
            // Kasus 1: Ada file baru dipilih → tampilkan preview file baru
            preview.src = URL.createObjectURL(fileInput.files[0]);
            preview.classList.remove('d-none');
            placeholder.classList.add('d-none');
            removeBtn.classList.remove('d-none');
        } else if (existingUrl && !isMarkedRemoved) {
            // Kasus 2: Ada foto lama di server dan belum ditandai hapus → tampilkan foto lama
            preview.src = existingUrl;
            preview.classList.remove('d-none');
            placeholder.classList.add('d-none');
            removeBtn.classList.remove('d-none');
        } else {
            // Kasus 3: Tidak ada foto sama sekali / foto sudah ditandai hapus
            preview.src = '';
            preview.classList.add('d-none');
            placeholder.classList.remove('d-none');
            removeBtn.classList.add('d-none');
        }
    }
    
    function updateFotoStatus(sbpId) {
        const fileInput = document.getElementById(`hidden-file-input-${sbpId}`);
        const statusFoto = document.getElementById(`status-foto-${sbpId}`);
        if (!statusFoto) return;

        const existingUrl = document.getElementById(`existing-photo-url-${sbpId}`)?.value;
        const isMarkedRemoved = document.getElementById(`remove-foto-hidden-${sbpId}`)?.value === '1';
        const fileIsSelected = fileInput && fileInput.files.length > 0;

        if (fileIsSelected) {
            // Ada file baru dipilih
            statusFoto.textContent = existingUrl ? 'Diganti' : 'Siap Diunggah';
            statusFoto.className = 'badge bg-warning text-dark';
        } else if (isMarkedRemoved) {
            // Foto lama ditandai untuk dihapus
            statusFoto.textContent = 'Akan Dihapus';
            statusFoto.className = 'badge bg-danger';
        } else if (existingUrl) {
            // Ada foto lama, tidak diubah
            statusFoto.textContent = 'Ada';
            statusFoto.className = 'badge bg-success';
        } else {
            // Tidak ada foto
            statusFoto.textContent = 'Kosong';
            statusFoto.className = 'badge bg-secondary';
        }
    }

    document.getElementById('btn-remove-foto-modal').addEventListener('click', () => {
        const sbpId = detailSbpModalElement.dataset.currentSbpId;
        const fileInput = document.getElementById(`hidden-file-input-${sbpId}`);
        const removeInput = document.getElementById(`remove-foto-hidden-${sbpId}`);
        const existingUrl = document.getElementById(`existing-photo-url-${sbpId}`)?.value;

        if (fileInput) {
            // Clear file input baru (jika ada)
            fileInput.value = '';
        }

        if (existingUrl && removeInput) {
            // Tandai foto lama untuk dihapus di backend
            removeInput.value = '1';
        }

        updateFotoPreview(sbpId);
        updateFotoStatus(sbpId);
    });

    // ═══════════════════════════════════════════════════════════════════
    // ATTACH HANDLERS ON PAGE LOAD
    // ═══════════════════════════════════════════════════════════════════
    function attachInitialHandlers() {
        document.querySelectorAll('[id^=hidden-file-input-]').forEach(input => {
            input.addEventListener('change', onFotoInputChange);
        });
    }

    attachInitialHandlers();
});
</script>
@endpush