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

                <h5 class="mb-3">Penomoran</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="no_ba_cacah_nomor" class="form-label">Nomor BA Cacah</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-notes"></i></span>
                                <input type="text"
                                    class="form-control"
                                    id="no_ba_cacah_nomor"
                                    placeholder="Masukkan hanya angka"
                                    required
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    value="{{ old('no_ba_cacah_nomor', old('no_ba_cacah') ? preg_replace('/[^0-9]/', '', explode('/', old('no_ba_cacah'))[0]) : '') }}">
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
                <h5 class="mb-3">Dokumen Terkait</h5>
                <div class="mb-3">
                    <label class="form-label">Dokumen SBP Terkait</label><br>
                    <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#sbpModal">
                        <i class="cil-file-plus me-2"></i> Tambah SBP
                    </button>

                    <div id="selectedSbpContainer" class="mt-3 row g-3">
                        @if(old('id_sbp') && isset($oldSbpData))
                            @foreach($oldSbpData as $sbp)
                                <div class="col-12" id="selected-sbp-{{ $sbp->id }}">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <div class="row g-3 align-items-center">
                                                <div class="col-md-8">
                                                    <h5 class="card-title text-primary mb-1">{{ $sbp->nomor_sbp }}</h5>
                                                    <p class="mb-2 text-muted small"><i class="cil-calendar me-2"></i>{{ \Carbon\Carbon::parse($sbp->tanggal_sbp)->translatedFormat('l, d F Y') }}</p>
                                                    <p class="mb-2"><strong>Pelaku:</strong> {{ $sbp->nama_pelaku ?? '-' }}</p>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <p class="mb-1"><strong>Jenis:</strong> {{ $sbp->jenis_barang ?? '-' }}</p>
                                                            <p class="mb-1"><strong>Kondisi:</strong> {{ $sbp->kondisi_barang ?? '-' }}</p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="mb-1"><strong>Uraian:</strong><br>{{ $sbp->uraian_barang ?? '-' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="foto-upload-wrapper">
                                                        <div class="foto-preview-container" onclick="document.getElementById('foto_barang_{{ $sbp->id }}').click()">
                                                            <img src="" alt="Pratinjau Foto" class="img-fluid rounded d-none">
                                                            <div class="foto-placeholder text-center">
                                                                <i class="cil-camera" style="font-size: 2rem;"></i>
                                                                <p class="mb-0 small">Unggah Foto</p>
                                                            </div>
                                                        </div>
                                                        <input type="file" name="foto_barang[{{ $sbp->id }}]" id="foto_barang_{{ $sbp->id }}" class="foto-input" accept="image/*" style="display:none;">
                                                        <div class="foto-actions text-center mt-2">
                                                            <button type="button" class="btn btn-sm btn-light border" onclick="document.getElementById('foto_barang_{{ $sbp->id }}').click()">Pilih</button>
                                                            <button type="button" class="btn btn-sm btn-light border d-none btn-remove-foto" onclick="removeImage(this, {{ $sbp->id }})">Hapus</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 d-flex justify-content-center">
                                                     <button type="button" class="btn btn-link text-danger p-0 btn-hapus-sbp" data-sbp-id="{{ $sbp->id }}" aria-label="Hapus"><i class="cil-trash" style="font-size: 1.5rem;"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="id_sbp[]" id="hidden-input-{{ $sbp->id }}" value="{{ $sbp->id }}">
                            @endforeach
                        @endif
                    </div>
                    <div id="hiddenSbpInputs"></div>
                </div>

                <div class="card-footer text-end bg-light">
                    <button type="submit" class="btn btn-primary"><i class="cil-save me-2"></i>Simpan Pencacahan</button>
                    <a href="{{ route('pencacahan.index') }}" class="btn btn-secondary"><i class="cil-x-circle me-2"></i>Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal SBP -->
<div class="modal fade" id="sbpModal" tabindex="-1" aria-labelledby="sbpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sbpModalLabel">Pilih Dokumen SBP</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="sbpSearchInput" class="form-control" placeholder="Cari berdasarkan Nomor SBP atau Nama Pelaku...">
                </div>
                <div id="sbpLoadingIndicator" class="text-center py-3 d-none">
                    <div class="spinner-border text-primary" role="status"></div><span class="ms-2">Memuat...</span>
                </div>
                <div id="sbpErrorAlert" class="alert alert-danger d-none"></div>
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center"><i class="cil-check-alt"></i></th>
                            <th>Nomor SBP</th>
                            <th>Tanggal SBP</th>
                            <th>Nama Pelaku</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="sbpTableBody">
                        <tr><td colspan="5" class="text-center text-muted">Ketik untuk mencari SBP...</td></tr>
                    </tbody>
                </table>
                <div id="sbpPagination" class="d-flex justify-content-center mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="selectSbpButton">Pilih</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .foto-upload-wrapper {
        border: 1px solid #ced4da;
        border-radius: .375rem;
        padding: 1rem;
        background-color: #f8f9fa;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .foto-preview-container {
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .foto-placeholder {
        color: #6c757d;
    }
    .row-dicacah {
        background-color: #e9ecef !important;
        color: #6c757d;
        cursor: not-allowed;
    }
    #sbpPagination .pagination {
        cursor: pointer;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const oldSbpIds = @json(old('id_sbp', []));
    const selectedSbpIds = new Set(oldSbpIds.map(id => id.toString()));

    const form = document.getElementById('createPencacahanForm');
    const tglInput = document.getElementById('tanggal_ba_cacah');
    const noBaCacahNomor = document.getElementById('no_ba_cacah_nomor');
    const noBaCacahHidden = document.getElementById('no_ba_cacah');

    form.addEventListener('submit', function () {
        const nomor = noBaCacahNomor.value.trim();
        if (nomor && tglInput.value) {
            const year = new Date(tglInput.value).getFullYear();
            noBaCacahHidden.value = `BA-${nomor}/CACAH/KBC.010202/${year}`;
        } else {
            noBaCacahHidden.value = '';
        }
    });

    function formatTanggal(raw) {
        if (!raw) return '-';
        const d = new Date(raw);
        return isNaN(d.getTime()) ? '-' : d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    }

    // ─── Image resize & preview ───────────────────────────────────────────────
    const MAX_DIM = 300;

    function resizeAndPreview(file, wrapper, sbpId) {
        const preview     = wrapper.querySelector('img');
        const placeholder = wrapper.querySelector('.foto-placeholder');
        const removeBtn   = wrapper.querySelector('.btn-remove-foto');

        const reader = new FileReader();
        reader.onload = function (e) {
            const img = new Image();
            img.onload = function () {
                let w = img.width;
                let h = img.height;
                if (w > MAX_DIM || h > MAX_DIM) {
                    if (w > h) {
                        h = Math.round(h * MAX_DIM / w);
                        w = MAX_DIM;
                    } else {
                        w = Math.round(w * MAX_DIM / h);
                        h = MAX_DIM;
                    }
                }

                const canvas = document.createElement('canvas');
                canvas.width  = w;
                canvas.height = h;
                canvas.getContext('2d').drawImage(img, 0, 0, w, h);

                preview.src = canvas.toDataURL('image/jpeg', 0.85);
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
                if (removeBtn) removeBtn.classList.remove('d-none');

                canvas.toBlob(function (blob) {
                    const dt   = new DataTransfer();
                    const nama = (file.name.replace(/\.[^.]+$/, '') || 'foto') + '.jpg';
                    dt.items.add(new File([blob], nama, { type: 'image/jpeg' }));
                    const fileInput = document.getElementById('foto_barang_' + sbpId);
                    if (fileInput) fileInput.files = dt.files;
                }, 'image/jpeg', 0.85);
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    function attachFotoListener(fileInput) {
        if (!fileInput) return;
        fileInput.addEventListener('change', function () {
            if (!this.files || !this.files[0]) return;
            const sbpId  = this.id.replace('foto_barang_', '');
            const wrapper = this.closest('.foto-upload-wrapper');
            resizeAndPreview(this.files[0], wrapper, sbpId);
        });
    }

    window.removeImage = function (button, sbpId) {
        const wrapper     = button.closest('.foto-upload-wrapper');
        const preview     = wrapper.querySelector('img');
        const placeholder = wrapper.querySelector('.foto-placeholder');
        const fileInput   = document.getElementById('foto_barang_' + sbpId);

        if (fileInput) fileInput.value = '';
        preview.src = '';
        preview.classList.add('d-none');
        placeholder.classList.remove('d-none');
        button.classList.add('d-none');
    };
    // ─────────────────────────────────────────────────────────────────────────

    const sbpSearchInput    = document.getElementById('sbpSearchInput');
    const sbpTableBody      = document.getElementById('sbpTableBody');
    const sbpLoadingIndicator = document.getElementById('sbpLoadingIndicator');
    const sbpErrorAlert     = document.getElementById('sbpErrorAlert');
    const sbpModalElement   = document.getElementById('sbpModal');
    const sbpPaginationContainer = document.getElementById('sbpPagination');

    function showModalError(msg) {
        sbpErrorAlert.textContent = msg;
        sbpErrorAlert.classList.remove('d-none');
    }

    function hideModalError() {
        sbpErrorAlert.classList.add('d-none');
    }

    function fetchSbp(url) {
        sbpLoadingIndicator.classList.remove('d-none');
        hideModalError();
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
                return response.json();
            })
            .then(data => {
                sbpTableBody.innerHTML = '';
                if (data.data.length === 0) {
                    sbpTableBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Data tidak ditemukan.</td></tr>';
                    sbpPaginationContainer.innerHTML = ''; // Clear pagination
                    return;
                }
                data.data.forEach(sbp => {
                    const tr = document.createElement('tr');
                    const isDicacah = sbp.pencacahan_exists;

                    if(isDicacah) {
                        tr.classList.add('row-dicacah');
                    }

                    tr.innerHTML = `
                        <td class="text-center">
                            <input class="form-check-input sbp-checkbox" type="checkbox" value="${sbp.id}" ${selectedSbpIds.has(sbp.id.toString()) ? 'checked' : ''} ${isDicacah ? 'disabled' : ''}
                            data-nomor-sbp="${sbp.nomor_sbp || ''}"
                            data-tanggal-sbp="${sbp.tanggal_sbp || ''}"
                            data-nama-pelaku="${sbp.nama_pelaku || ''}"
                            data-jenis-barang="${sbp.jenis_barang || ''}"
                            data-uraian-barang="${sbp.uraian_barang || ''}"
                            data-kondisi-barang="${sbp.kondisi_barang || ''}"
                            >
                        </td>
                        <td>${sbp.nomor_sbp || '-'}</td>
                        <td>${formatTanggal(sbp.tanggal_sbp)}</td>
                        <td>${sbp.nama_pelaku || '-'}</td>
                        <td>
                            <span class="badge bg-${isDicacah ? 'success' : 'secondary'}">${isDicacah ? 'Sudah dicacah' : 'Belum dicacah'}</span>
                        </td>
                    `;
                    sbpTableBody.appendChild(tr);
                });

                sbpPaginationContainer.innerHTML = data.pagination;
            })
            .catch(error => {
                console.error('Fetch SBP error:', error);
                showModalError('Gagal memuat data SBP. Silakan coba lagi.');
                sbpTableBody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Terjadi kesalahan.</td></tr>';
                sbpPaginationContainer.innerHTML = ''; // Clear pagination on error
            })
            .finally(() => sbpLoadingIndicator.classList.add('d-none'));
    }

    let searchTimeout;
    sbpSearchInput.addEventListener('keyup', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const searchTerm = sbpSearchInput.value.trim();
            const url = `{{ route('pencacahan.searchSbp') }}?search=${encodeURIComponent(searchTerm)}`;
            fetchSbp(url);
        }, 300);
    });

    sbpPaginationContainer.addEventListener('click', function(event) {
        event.preventDefault();
        const link = event.target.closest('a.page-link');
        if (link) {
            const url = link.getAttribute('href');
            if (url) {
                fetchSbp(url);
            }
        }
    });

    sbpModalElement.addEventListener('show.coreui.modal', () => {
        sbpSearchInput.value = '';
        hideModalError();
        const url = `{{ route('pencacahan.searchSbp') }}?search=`;
        fetchSbp(url);
    });

    const selectSbpButton      = document.getElementById('selectSbpButton');
    const selectedSbpContainer = document.getElementById('selectedSbpContainer');
    const hiddenInputsDiv      = document.getElementById('hiddenSbpInputs');

    selectSbpButton.addEventListener('click', () => {
        const checkboxes = document.querySelectorAll('#sbpTableBody .sbp-checkbox:checked');
        if (checkboxes.length === 0) {
            showModalError('Pilih minimal satu SBP terlebih dahulu.');
            return;
        }
        hideModalError();
        checkboxes.forEach(checkbox => {
            const sbpId = checkbox.value;
            if (!selectedSbpIds.has(sbpId)) {
                addSbpCard(checkbox.dataset, sbpId);
                selectedSbpIds.add(sbpId);
            }
        });
        coreui.Modal.getInstance(sbpModalElement)?.hide();
    });

    function addSbpCard(dataset, sbpId) {
        if (!sbpId) return;

        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = 'id_sbp[]';
        input.value = sbpId;
        input.id    = `hidden-input-${sbpId}`;
        hiddenInputsDiv.appendChild(input);

        const col = document.createElement('div');
        col.className = 'col-12';
        col.id        = `selected-sbp-${sbpId}`;

        col.innerHTML = `
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title text-primary mb-1">${dataset.nomorSbp}</h5>
                            <p class="mb-2 text-muted small"><i class="cil-calendar me-2"></i>${formatTanggal(dataset.tanggalSbp)}</p>
                            <p class="mb-2"><strong>Pelaku:</strong> ${dataset.namaPelaku || '-'}</p>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="mb-1"><strong>Jenis:</strong> ${dataset.jenisBarang || '-'}</p>
                                    <p class="mb-1"><strong>Kondisi:</strong> ${dataset.kondisiBarang || '-'}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="mb-1"><strong>Uraian:</strong><br>${dataset.uraianBarang || '-'}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="foto-upload-wrapper">
                                <div class="foto-preview-container" onclick="document.getElementById('foto_barang_${sbpId}').click()">
                                    <img src="" alt="Pratinjau Foto" class="img-fluid rounded d-none">
                                    <div class="foto-placeholder text-center">
                                        <i class="cil-camera" style="font-size: 2rem;"></i>
                                        <p class="mb-0 small">Unggah Foto</p>
                                    </div>
                                </div>
                                <input type="file" name="foto_barang[${sbpId}]" id="foto_barang_${sbpId}" class="foto-input" accept="image/*" style="display:none;">
                                <div class="foto-actions text-center mt-2">
                                    <button type="button" class="btn btn-sm btn-light border" onclick="document.getElementById('foto_barang_${sbpId}').click()">Pilih</button>
                                    <button type="button" class="btn btn-sm btn-light border d-none btn-remove-foto" onclick="removeImage(this, ${sbpId})">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 d-flex justify-content-center">
                            <button type="button" class="btn btn-link text-danger p-0 btn-hapus-sbp" data-sbp-id="${sbpId}" aria-label="Hapus"><i class="cil-trash" style="font-size: 1.5rem;"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        selectedSbpContainer.appendChild(col);
        attachFotoListener(col.querySelector('.foto-input'));
    }

    // Pasang listener untuk card yang di-render ulang (setelah validasi error)
    document.querySelectorAll('.foto-input').forEach(attachFotoListener);

    selectedSbpContainer.addEventListener('click', event => {
        const btnHapus = event.target.closest('.btn-hapus-sbp[data-sbp-id]');
        if (!btnHapus) return;

        const sbpId = btnHapus.dataset.sbpId;
        document.getElementById(`selected-sbp-${sbpId}`)?.remove();
        document.getElementById(`hidden-input-${sbpId}`)?.remove();

        const checkbox = document.querySelector(`#sbpTableBody .sbp-checkbox[value="${sbpId}"]`);
        if (checkbox) checkbox.checked = false;

        selectedSbpIds.delete(sbpId);
    });
});
</script>
@endpush
