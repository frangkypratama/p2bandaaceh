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
                                <input type="hidden" name="detail_barang_json[{{$sbpId}}]" id="hidden-barang-json-{{$sbpId}}" value=\'{{ old("detail_barang_json.$sbpId") }}\'>
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
    .conditional-fields-container { animation: fadeIn 0.5s; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
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
    const jenisBarangOptions = @json($jenisBarangData);

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
                } catch (error) { console.error('Error parsing barang JSON:', error, jsonString); }
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
        if (barangData.length > 0 && barangData.some(d => d.id_jenis_barang)) {
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
                const barangData = JSON.parse(jsonString.replace(/\'/g, '"')); // Handle single quotes from old()
                const statusDetail = document.getElementById(`status-detail-${sbpId}`);
                if(statusDetail && barangData.length > 0 && barangData.some(d => d.id_jenis_barang)) {
                    statusDetail.textContent = 'Sudah Diisi';
                    statusDetail.className = 'badge bg-success';
                }
            } catch(e) { console.error('Failed to parse old JSON for ' + sbpId, jsonString); }
        }
    });

    // --- Repeater Logic ---
    const barangContainer = document.getElementById('barangItemsContainer');
    const btnTambah = document.getElementById('btnTambahBarang');
    const emptyMessage = document.getElementById('emptyBarangMessage');

    // Event delegation for calculating total
    barangContainer.addEventListener('input', function(e) {
        if (e.target.matches('[data-field="jumlah_bungkus"]') || e.target.matches('[data-field="jumlah_batang"]')) {
            const itemCard = e.target.closest('.barang-item');
            if (itemCard) {
                const jumlahBungkusInput = itemCard.querySelector('[data-field="jumlah_bungkus"]');
                const jumlahBatangInput = itemCard.querySelector('[data-field="jumlah_batang"]');
                const totalBatangInput = itemCard.querySelector('[data-field="total_batang"]');

                if (jumlahBungkusInput && jumlahBatangInput && totalBatangInput) {
                    const bungkus = parseInt(jumlahBungkusInput.value, 10) || 0;
                    const batang = parseInt(jumlahBatangInput.value, 10) || 0;
                    totalBatangInput.value = bungkus * batang;
                }
            }
        }
    });

    window.updateEmptyMessage = () => {
        emptyMessage.classList.toggle('d-none', barangContainer.children.length > 1);
    }

    window.renumberBarang = () => {
        barangContainer.querySelectorAll('.barang-item').forEach((item, index) => {
            item.querySelector('.barang-number').textContent = `Barang ${index + 1}`;
        });
    }

    function buildSatuanOptions(selectedValue = null) {
        let opts = '<option value="" disabled>Pilih Satuan</option>';
        satuanOptions.forEach(s => {
            const selected = s.id == selectedValue ? 'selected' : '';
            opts += `<option value="${s.id}" ${selected}>${s.nama_satuan}</option>`;
        });
        if (!selectedValue) {
            opts = opts.replace('disabled', 'selected disabled');
        }
        return opts;
    }

    function buildJenisBarangOptions() {
        return '<option value="" selected disabled>Pilih Jenis Barang</option>' + jenisBarangOptions.map((jb, index) => `<option value="${jb.id}" data-nama="${jb.nama_barang}">${index + 1}. ${jb.nama_barang}</option>`).join('');
    }

    function defaultFieldsHTML(data = {}) {
        return `
            <div class="mb-3">
                <label class="form-label">Merek</label>
                <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Merek Barang" value="${data.merek || ''}">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" class="form-control" data-field="jumlah" min="1" placeholder="0" value="${data.jumlah || ''}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Satuan</label>
                    <select class="form-select" data-field="id_satuan">
                        ${buildSatuanOptions(data.id_satuan)}
                    </select>
                </div>
            </div>
        `;
    }

    function getConditionalFieldsHTML(namaBarang, data = {}) {
        const specialFields = {};
        
        specialFields['Hasil Tembakau'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Gudang Garam" value="${data.merek || ''}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Tarif Cukai</label>
                    <select class="form-select" data-field="jenis_tarif_cukai">
                        <option value="" ${!data.jenis_tarif_cukai ? 'selected' : ''}>Pilih Jenis</option>
                        <option value="SPM GOL I" ${data.jenis_tarif_cukai === 'SPM GOL I' ? 'selected' : ''}>SPM GOL I</option>
                        <option value="SPM GOL II" ${data.jenis_tarif_cukai === 'SPM GOL II' ? 'selected' : ''}>SPM GOL II</option>
                        <option value="SKM GOL I" ${data.jenis_tarif_cukai === 'SKM GOL I' ? 'selected' : ''}>SKM GOL I</option>
                        <option value="SKM GOL II" ${data.jenis_tarif_cukai === 'SKM GOL II' ? 'selected' : ''}>SKM GOL II</option>
                        <option value="SKT GOL I" ${data.jenis_tarif_cukai === 'SKT GOL I' ? 'selected' : ''}>SKT GOL I</option>
                        <option value="SKT GOL II" ${data.jenis_tarif_cukai === 'SKT GOL II' ? 'selected' : ''}>SKT GOL II</option>
                        <option value="SKT GOL III" ${data.jenis_tarif_cukai === 'SKT GOL III' ? 'selected' : ''}>SKT GOL III</option>
                        <option value="CRT" ${data.jenis_tarif_cukai === 'CRT' ? 'selected' : ''}>CRT</option>
                    </select>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Bungkus</label>
                    <input type="number" class="form-control" data-field="jumlah_bungkus" min="1" placeholder="10" value="${data.jumlah_bungkus || ''}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Batang/Bks</label>
                    <input type="number" class="form-control" data-field="jumlah_batang" min="1" placeholder="20" value="${data.jumlah_batang || ''}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Total Batang</label>
                    <input type="number" class="form-control" data-field="total_batang" placeholder="0" readonly>
                </div>
            </div>
        `;
        specialFields['Handphone, Gadget, Part & Accesories'] = `
            <div class="mb-3">
                <label class="form-label">Merek</label>
                <input type="text" class="form-control" data-field="merek" placeholder="Contoh: iPhone, Samsung" value="${data.merek || ''}">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">IMEI 1</label>
                    <input type="text" class="form-control" data-field="imei1" placeholder="Masukkan IMEI 1" value="${data.imei1 || ''}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">IMEI 2 (Opsional)</label>
                    <input type="text" class="form-control" data-field="imei2" placeholder="Masukkan IMEI 2" value="${data.imei2 || ''}">
                </div>
            </div>
             <div class="mb-3">
                <label class="form-label">Warna</label>
                <input type="text" class="form-control" data-field="warna" placeholder="Contoh: Biru, Hitam" value="${data.warna || ''}">
            </div>
        `;
        specialFields['Minuman Mengandung Etil Alkohol'] = `
            <div class="mb-3">
                <label class="form-label">Merek</label>
                <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Johnnie Walker" value="${data.merek || ''}">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kadar Alkohol (%)</label>
                    <input type="number" class="form-control" data-field="kadar_alkohol" step="0.1" min="0" placeholder="40" value="${data.kadar_alkohol || ''}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Volume (ml)</label>
                    <input type="number" class="form-control" data-field="volume" min="0" placeholder="750" value="${data.volume || ''}">
                </div>
            </div>
            <div class="row">
                 <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah Botol</label>
                    <input type="number" class="form-control" data-field="jumlah_botol" min="1" placeholder="12" value="${data.jumlah_botol || ''}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis MMEA</label>
                    <select class="form-select" data-field="jenis_mmea">
                        <option value="" ${!data.jenis_mmea ? 'selected' : ''}>Pilih Jenis</option>
                        <option value="Bir" ${data.jenis_mmea === 'Bir' ? 'selected' : ''}>Bir</option>
                        <option value="Anggur" ${data.jenis_mmea === 'Anggur' ? 'selected' : ''}>Anggur</option>
                        <option value="Spirit" ${data.jenis_mmea === 'Spirit' ? 'selected' : ''}>Spirit</option>
                        <option value="Lainnya" ${data.jenis_mmea === 'Lainnya' ? 'selected' : ''}>Lainnya</option>
                    </select>
                </div>
            </div>
        `;
        specialFields['Narkotika, Psikotropika, dan Prekursor'] = `
            <div class="mb-3">
                <label class="form-label">Jenis Zat</label>
                <select class="form-select" data-field="jenis_zat">
                    <option value="" ${!data.jenis_zat ? 'selected' : ''}>Pilih Jenis</option>
                    <option value="Narkotika" ${data.jenis_zat === 'Narkotika' ? 'selected' : ''}>Narkotika</option>
                    <option value="Psikotropika" ${data.jenis_zat === 'Psikotropika' ? 'selected' : ''}>Psikotropika</option>
                    <option value="Prekursor" ${data.jenis_zat === 'Prekursor' ? 'selected' : ''}>Prekursor</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Zat</label>
                <input type="text" class="form-control" data-field="nama_zat" placeholder="Contoh: Metamfetamin, Alprazolam" value="${data.nama_zat || ''}">
            </div>
             <div class="mb-3">
                <label class="form-label">Bentuk Sediaan</label>
                <input type="text" class="form-control" data-field="bentuk_sediaan" placeholder="Contoh: Kristal, Tablet, Bubuk" value="${data.bentuk_sediaan || ''}">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Berat (gram)</label>
                    <input type="number" class="form-control" data-field="berat" step="0.01" min="0" placeholder="10.5" value="${data.berat || ''}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah Kemasan/Wadah</label>
                    <input type="number" class="form-control" data-field="jumlah_kemasan" min="1" placeholder="5" value="${data.jumlah_kemasan || ''}">
                </div>
            </div>
        `;
        specialFields['Kosmetik'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" data-field="nama_produk" placeholder="Contoh: Facial Wash" value="${data.nama_produk || ''}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Scarlett" value="${data.merek || ''}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Izin Edar (BPOM)</label>
                    <input type="text" class="form-control" data-field="no_bpom" placeholder="Contoh: NA18211204238" value="${data.no_bpom || ''}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Kadaluwarsa</label>
                    <input type="date" class="form-control" data-field="tanggal_kadaluwarsa" value="${data.tanggal_kadaluwarsa || ''}">
                </div>
            </div>
        `;
        specialFields['Obat-Obatan'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Obat</label>
                    <input type="text" class="form-control" data-field="nama_obat" placeholder="Contoh: Paracetamol" value="${data.nama_obat || ''}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Panadol" value="${data.merek || ''}">
                </div>
            </div>
            <div class="row">
                 <div class="col-md-4 mb-3">
                    <label class="form-label">Bentuk Sediaan</label>
                    <select class="form-select" data-field="bentuk_sediaan">
                        <option value="" ${!data.bentuk_sediaan ? 'selected' : ''}>Pilih Bentuk</option>
                        <option value="Tablet" ${data.bentuk_sediaan === 'Tablet' ? 'selected' : ''}>Tablet</option>
                        <option value="Kapsul" ${data.bentuk_sediaan === 'Kapsul' ? 'selected' : ''}>Kapsul</option>
                        <option value="Sirup" ${data.bentuk_sediaan === 'Sirup' ? 'selected' : ''}>Sirup</option>
                        <option value="Lainnya" ${data.bentuk_sediaan === 'Lainnya' ? 'selected' : ''}>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" class="form-control" data-field="jumlah" min="1" placeholder="10" value="${data.jumlah || ''}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Satuan</label>
                    <select class="form-select" data-field="id_satuan">
                        ${buildSatuanOptions(data.id_satuan)}
                    </select>
                </div>
            </div>
        `;
        specialFields['Elektronik'] = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Elektronik</label>
                    <input type="text" class="form-control" data-field="jenis_elektronik" placeholder="Contoh: TV, Kulkas" value="${data.jenis_elektronik || ''}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Samsung" value="${data.merek || ''}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Model/No. Seri</label>
                    <input type="text" class="form-control" data-field="model_seri" placeholder="Contoh: UA43AU7000KXXD" value="${data.model_seri || ''}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ukuran</label>
                    <input type="text" class="form-control" data-field="ukuran" placeholder="Contoh: 43 inch" value="${data.ukuran || ''}">
                </div>
            </div>
        `;
        specialFields['Kendaraan Darat (Bermotor/Tidak), Part & Accessories'] = `
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jenis Kendaraan</label>
                     <select class="form-select" data-field="jenis_kendaraan">
                        <option value="" ${!data.jenis_kendaraan ? 'selected' : ''}>Pilih Jenis</option>
                        <option value="Mobil" ${data.jenis_kendaraan === 'Mobil' ? 'selected' : ''}>Mobil</option>
                        <option value="Motor" ${data.jenis_kendaraan === 'Motor' ? 'selected' : ''}>Motor</option>
                        <option value="Sepeda" ${data.jenis_kendaraan === 'Sepeda' ? 'selected' : ''}>Sepeda</option>
                        <option value="Lainnya" ${data.jenis_kendaraan === 'Lainnya' ? 'selected' : ''}>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Toyota" value="${data.merek || ''}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipe</label>
                    <input type="text" class="form-control" data-field="tipe" placeholder="Contoh: Avanza" value="${data.tipe || ''}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Rangka</label>
                    <input type="text" class="form-control" data-field="nomor_rangka" placeholder="Masukkan nomor rangka" value="${data.nomor_rangka || ''}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Mesin</label>
                    <input type="text" class="form-control" data-field="nomor_mesin" placeholder="Masukkan nomor mesin" value="${data.nomor_mesin || ''}">
                </div>
            </div>
        `;



        if (specialFields[namaBarang]) {
            return specialFields[namaBarang];
        }
        if (!namaBarang) {
            return '<div class="text-center text-muted p-3">Pilih jenis barang untuk menampilkan detail isian.</div>';
        }
        return defaultFieldsHTML(data);
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
                    <label class="form-label">Jenis Barang</label>
                    <select class="form-select input-jenis-barang">
                        ${buildJenisBarangOptions()}
                    </select>
                </div>
                <div class="conditional-fields-container">
                    ${data.id_jenis_barang ? getConditionalFieldsHTML(jenisBarangOptions.find(j=>j.id == data.id_jenis_barang)?.nama_barang, data) : '<div class="text-center text-muted p-3">Pilih jenis barang untuk menampilkan detail isian.</div>'}
                </div>
            </div>
        `;
        barangContainer.appendChild(item);
        
        const jenisBarangSelect = item.querySelector('.input-jenis-barang');
        if (data.id_jenis_barang) {
            jenisBarangSelect.value = data.id_jenis_barang;
        }

        jenisBarangSelect.addEventListener('change', (e) => {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const namaBarang = selectedOption.dataset.nama;
            const conditionalContainer = item.querySelector('.conditional-fields-container');
            conditionalContainer.innerHTML = getConditionalFieldsHTML(namaBarang);
        });

        updateEmptyMessage();
        renumberBarang();
    }

    btnTambah.addEventListener('click', () => {
        addRepeaterItem();
        barangContainer.lastChild.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });

    barangContainer.addEventListener('click', (e) => {
        const btnHapus = e.target.closest('.btn-hapus-barang');
        if (!btnHapus) return;
        btnHapus.closest('.barang-item').remove();
        renumberBarang();
        updateEmptyMessage();
    });

    window.getBarangData = () => {
        const data = [];
        barangContainer.querySelectorAll('.barang-item').forEach((item, index) => {
            const jenisBarangSelect = item.querySelector('.input-jenis-barang');
            if (!jenisBarangSelect.value) return; // Skip if no type is selected

            const itemData = {
                urutan: index + 1,
                id_jenis_barang: jenisBarangSelect.value,
            };

            item.querySelectorAll('.conditional-fields-container [data-field]').forEach(field => {
                itemData[field.dataset.field] = field.value.trim();
            });
            data.push(itemData);
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
