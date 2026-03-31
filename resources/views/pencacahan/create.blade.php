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
                                <input type="hidden" name="detail_barang_json[{{$sbpId}}]" id="hidden-barang-json-{{$sbpId}}" value='{{ old("detail_barang_json.$sbpId") }}'>
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
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Main Form and Modal Logic ---
    const sbpModalElement = document.getElementById('sbpModal');
    const detailSbpModalElement = document.getElementById('detailSbpModal');
    const detailSbpModal = new coreui.Modal(detailSbpModalElement);
    const selectedSbpIds = new Set(@json(old('id_sbp', [])).map(id => id.toString()));
    const satuanOptions = @json($satuanData);

    function formatTanggal(raw) {
        if (!raw) return '-';
        const d = new Date(raw);
        return isNaN(d.getTime()) ? '-' : d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    }

    document.getElementById('createPencacahanForm').addEventListener('submit', function () {
        const nomor = document.getElementById('no_ba_cacah_nomor').value.trim();
        const tgl = document.getElementById('tanggal_ba_cacah').value;
        if (nomor && tgl) {
            const year = new Date(tgl).getFullYear();
            document.getElementById('no_ba_cacah').value = `BA-${nomor}/CACAH/KBC.010202/${year}`;
        }
    });

    function fetchSbp(url) {
        document.getElementById('sbpLoadingIndicator').classList.remove('d-none');
        document.getElementById('sbpErrorAlert').classList.add('d-none');
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.ok ? response.json() : Promise.reject('Gagal mengambil data'))
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
                            <td class="text-center"><input class="form-check-input sbp-checkbox" type="checkbox" value="${sbp.id}" ${selectedSbpIds.has(sbp.id.toString()) ? 'checked' : ''} ${sbp.pencacahan_exists ? 'disabled' : ''} data-nomor-sbp="${sbp.nomor_sbp || ''}" data-tanggal-sbp="${sbp.tanggal_sbp || ''}" data-jenis-barang="${sbp.jenis_barang || ''}" data-uraian-barang="${sbp.uraian_barang || ''}"></td>
                            <td>${sbp.nomor_sbp || '-'}</td>
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

    function addSbpRow(dataset, sbpId) {
        const tbody = document.getElementById('selectedSbpTableBody');
        const tr = document.createElement('tr');
        tr.id = `selected-row-${sbpId}`;
        tr.innerHTML = `
            <td>${dataset.nomorSbp}</td>
            <td>${formatTanggal(dataset.tanggalSbp)}</td>
            <td class="text-center"><span class="badge bg-secondary" id="status-detail-${sbpId}">Belum Diisi</span></td>
            <td class="text-center"><span class="badge bg-secondary" id="status-foto-${sbpId}">Belum Diunggah</span></td>
            <td class="text-center">
                <button type="button" class="btn btn-info btn-sm text-white btn-detail-sbp" data-sbp-id="${sbpId}" data-nomor-sbp="${dataset.nomorSbp}" data-tanggal-sbp="${dataset.tanggalSbp}" data-jenis-barang="${dataset.jenisBarang}" data-uraian-barang="${dataset.uraianBarang}"><i class="cil-search me-1"></i> Detail</button>
                <button type="button" class="btn btn-danger btn-sm text-white btn-hapus-sbp" data-sbp-id="${sbpId}"><i class="cil-trash"></i></button>
            </td>`;
        tbody.appendChild(tr);
        const hiddenInputsDiv = document.getElementById('hiddenSbpInputs');
        hiddenInputsDiv.insertAdjacentHTML('beforeend', `<input type="hidden" name="id_sbp[]" id="hidden-input-${sbpId}" value="${sbpId}">`);
        hiddenInputsDiv.insertAdjacentHTML('beforeend', `<input type="hidden" name="detail_barang_json[${sbpId}]" id="hidden-barang-json-${sbpId}">`);
    }

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

            // --- Logic to load repeater data ---
            const barangContainer = document.getElementById('barangItemsContainer');
            barangContainer.innerHTML = ''; // Clear previous items
            const jsonString = document.getElementById(`hidden-barang-json-${sbpId}`).value;
            if (jsonString) {
                try {
                    const barangData = JSON.parse(jsonString);
                    if (Array.isArray(barangData)) {
                        barangData.forEach(itemData => addRepeaterItem(itemData));
                    }
                } catch (error) { console.error('Error parsing barang JSON:', error); }
            }
            updateEmptyMessage();
            renumberBarang();

            // --- Logic to load photo preview ---
            const fileInput = document.getElementById(`foto_barang_${sbpId}`);
            const preview = document.getElementById('foto_preview_modal');
            const placeholder = document.querySelector('.foto-placeholder-modal');
            const removeBtn = document.getElementById('btn-remove-foto-modal');
            if(fileInput && fileInput.files[0]) {
                preview.src = URL.createObjectURL(fileInput.files[0]);
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
                removeBtn.classList.remove('d-none');
            } else {
                preview.src = '';
                preview.classList.add('d-none');
                placeholder.classList.remove('d-d-none');
                removeBtn.classList.add('d-none');
            }
            detailSbpModal.show();
        }
    });

    document.getElementById('saveSbpDetailButton').addEventListener('click', () => {
        const sbpId = detailSbpModalElement.dataset.currentSbpId;
        
        // --- Save Repeater Data ---
        const barangData = getBarangData();
        document.getElementById(`hidden-barang-json-${sbpId}`).value = JSON.stringify(barangData);

        const statusDetail = document.getElementById(`status-detail-${sbpId}`);
        if (barangData.length > 0 && barangData.some(d => d.merek || d.jumlah || d.id_satuan)) {
            statusDetail.textContent = 'Sudah Diisi';
            statusDetail.className = 'badge bg-success';
        } else {
            statusDetail.textContent = 'Belum Diisi';
            statusDetail.className = 'badge bg-secondary';
        }

        // --- Save Photo Data ---
        const modalFileInput = document.getElementById('foto_barang_modal');
        let fileInput = document.getElementById(`foto_barang_${sbpId}`);
        if (!fileInput) {
            fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.name = `foto_barang[${sbpId}]`;
            fileInput.id = `foto_barang_${sbpId}`;
            document.getElementById('hiddenFileInputs').appendChild(fileInput);
        }
        if (modalFileInput.files.length > 0) {
            fileInput.files = modalFileInput.files;
        }

        const statusFoto = document.getElementById(`status-foto-${sbpId}`);
        statusFoto.textContent = fileInput.files.length > 0 ? 'Siap Diunggah' : 'Belum Diunggah';
        statusFoto.className = `badge bg-${fileInput.files.length > 0 ? 'success' : 'secondary'}`;

        detailSbpModal.hide();
    });
    
    // Restore state from old input for status badges
    selectedSbpIds.forEach(sbpId => {
        const jsonString = document.getElementById(`hidden-barang-json-${sbpId}`)?.value;
        if(jsonString) {
            try {
                const barangData = JSON.parse(jsonString.replace(/'/g, '"')); // Handle single quotes from old()
                const statusDetail = document.getElementById(`status-detail-${sbpId}`);
                if(statusDetail && barangData.length > 0 && barangData.some(d => d.merek || d.jumlah || d.id_satuan)) {
                    statusDetail.textContent = 'Sudah Diisi';
                    statusDetail.className = 'badge bg-success';
                }
            } catch(e) { console.error('Failed to parse old JSON for ' + sbpId, jsonString); }
        }
    });

    // --- Repeater Logic (from your script) ---
    const barangContainer = document.getElementById('barangItemsContainer');
    const btnTambah = document.getElementById('btnTambahBarang');
    const emptyMessage = document.getElementById('emptyBarangMessage');

    window.updateEmptyMessage = function() {
        const items = barangContainer.querySelectorAll('.barang-item');
        emptyMessage.classList.toggle('d-none', items.length > 0);
    }

    window.renumberBarang = function() {
        const items = barangContainer.querySelectorAll('.barang-item');
        items.forEach((item, index) => {
            item.querySelector('.barang-number').textContent = `Barang ${index + 1}`;
        });
    }

    function buildSatuanOptions() {
        let opts = '<option value="" selected disabled>Pilih Satuan</option>';
        satuanOptions.forEach(s => {
            opts += `<option value="${s.id}">${s.nama_satuan}</option>`;
        });
        return opts;
    }

    function addRepeaterItem(data = {}) {
        const item = document.createElement('div');
        item.className = 'barang-item card mb-3 border';
        item.innerHTML = `
            <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                <span class="fw-semibold barang-number">Barang</span>
                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-barang" title="Hapus barang ini">
                    <i class="cil-trash"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" class="form-control input-merek" placeholder="Contoh: iPhone, Samsung" value="${data.merek || ''}">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" class="form-control input-jumlah" min="1" placeholder="0" value="${data.jumlah || ''}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Satuan</label>
                        <select class="form-select input-satuan">
                            ${buildSatuanOptions()}
                        </select>
                    </div>
                </div>
            </div>
        `;
        barangContainer.appendChild(item);
        item.querySelector('.input-satuan').value = data.id_satuan || ''; // Set value after appending
    }

    btnTambah.addEventListener('click', function () {
        addRepeaterItem();
        renumberBarang();
        updateEmptyMessage();
        barangContainer.lastChild.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });

    barangContainer.addEventListener('click', function (e) {
        const btnHapus = e.target.closest('.btn-hapus-barang');
        if (!btnHapus) return;
        const item = btnHapus.closest('.barang-item');
        item.remove();
        renumberBarang();
        updateEmptyMessage();
    });

    window.getBarangData = function () {
        const items = barangContainer.querySelectorAll('.barang-item');
        const data = [];
        items.forEach((item, index) => {
            data.push({
                urutan: index + 1,
                merek: item.querySelector('.input-merek').value.trim(),
                jumlah: item.querySelector('.input-jumlah').value,
                id_satuan: item.querySelector('.input-satuan').value,
            });
        });
        return data;
    };
    
    // --- Photo Preview Logic ---
    document.getElementById('foto-upload-modal-trigger').addEventListener('click', () => document.getElementById('foto_barang_modal').click());
    
    document.getElementById('foto_barang_modal').addEventListener('change', function() {
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
        const modalFileInput = document.getElementById('foto_barang_modal');
        modalFileInput.value = '';
        modalFileInput.dispatchEvent(new Event('change')); // Trigger change to update UI
    });
});
</script>
@endpush
