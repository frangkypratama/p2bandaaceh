@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-md-10">

                {{-- Form Card --}}
                <div class="card">
                    <div class="card-header">
                        <strong>Buat Laporan Pelaksanaan Tugas (LPT)</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('lpt.store') }}" method="POST" enctype="multipart/form-data" id="lptForm">
                            @csrf

                            {{-- Jenis LPT --}}
                            <div class="form-group mb-3">
                                <label for="jenis_lpt" class="form-label">Jenis LPT</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="cil-tag"></i></span>
                                    <select class="form-select @error('jenis_lpt') is-invalid @enderror"
                                            id="jenis_lpt" name="jenis_lpt" required {{ $jenis ? 'disabled' : '' }}>
                                        <option value="" disabled {{ !$jenis ? 'selected' : '' }}>Pilih Jenis LPT...</option>
                                        @foreach($jenis_lpt_options as $pilihan_jenis_lpt => $options)
                                            <option value="{{ $pilihan_jenis_lpt }}"
                                                    {{ old('jenis_lpt', $jenis) == $pilihan_jenis_lpt ? 'selected' : '' }}>
                                                {{ $options['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($jenis)
                                        <input type="hidden" name="jenis_lpt" value="{{ $jenis }}" />
                                    @endif
                                </div>
                                @error('jenis_lpt')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Penomoran LPT --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nomor_lpt_int" class="form-label">Nomor LPT</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-notes"></i></span>
                                            <input type="number"
                                                   class="form-control @error('nomor_lpt_int') is-invalid @enderror"
                                                   id="nomor_lpt_int" name="nomor_lpt_int"
                                                   value="{{ old('nomor_lpt_int') }}"
                                                   placeholder="Hanya isi dengan angka" required>
                                        </div>
                                        @error('nomor_lpt_int')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="tanggal_lpt" class="form-label">Tanggal LPT</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-calendar"></i></span>
                                            <input type="date"
                                                   class="form-control @error('tanggal_lpt') is-invalid @enderror"
                                                   id="tanggal_lpt" name="tanggal_lpt"
                                                   value="{{ old('tanggal_lpt', date('Y-m-d')) }}" required>
                                        </div>
                                        @error('tanggal_lpt')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- SBP Selection --}}
                            <div class="form-group mb-3">
                                <label for="nomor_sbp_display" class="form-label">Nomor SBP</label>
                                <div class="input-group">
                                    <input type="text"
                                           class="form-control @error('sbp_id') is-invalid @enderror"
                                           id="nomor_sbp_display" placeholder="Pilih SBP..." readonly>
                                    <button class="btn btn-outline-primary" type="button" data-coreui-toggle="modal" data-coreui-target="#sbpModal">
                                        <i class="cil-search me-1"></i>Pilih SBP
                                    </button>
                                </div>
                                <input type="hidden" name="sbp_id" id="sbp_id">
                                @error('sbp_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Photo Upload --}}
                            <div class="form-group mb-3">
                                <label class="form-label">Upload Foto</label>
                                <div class="upload-dropzone" id="uploadDropzone">
                                    <input type="file"
                                           class="upload-dropzone-input @error('photos.*') is-invalid @enderror"
                                           id="photos" name="photos[]"
                                           multiple accept="image/*">
                                    <div class="upload-dropzone-body">
                                        <div class="upload-dropzone-icon">
                                            <i class="cil-cloud-upload"></i>
                                        </div>
                                        <div class="upload-dropzone-title">Klik atau seret foto ke sini</div>
                                        {{-- [UBAH 1] teks hint --}}
                                        <div class="upload-dropzone-sub">JPG, PNG — otomatis dikompres maks. 300 KB per file</div>
                                    </div>
                                </div>
                                @error('photos.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                {{-- Compression Progress --}}
                                <div class="upload-progress" id="uploadProgress">
                                    <div class="upload-progress-info">
                                        <div class="upload-spinner"></div>
                                        <span class="upload-progress-text" id="progressText">Memproses...</span>
                                    </div>
                                    <div class="upload-progress-track">
                                        <div class="upload-progress-fill" id="progressFill"></div>
                                    </div>
                                </div>

                                {{-- Photo Preview --}}
                                <div class="upload-preview" id="uploadPreview">
                                    <div class="upload-preview-header">
                                        <div class="upload-preview-title">
                                            <i class="cil-image1 me-1"></i>
                                            Preview foto
                                            <span class="upload-preview-count" id="photoCount">0</span>
                                        </div>
                                        <button type="button" class="upload-preview-clear" id="clearAllBtn">
                                            <i class="cil-trash me-1"></i>Hapus semua
                                        </button>
                                    </div>
                                    <div class="upload-grid" id="photoGrid"></div>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="form-group mt-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="cil-save me-1"></i>Simpan
                                </button>
                                <a href="{{ route('lpt.index') }}" class="btn btn-secondary">
                                    <i class="cil-x-circle me-1"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal SBP -->
    <div class="modal fade" id="sbpModal" tabindex="-1" aria-labelledby="sbpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sbpModalLabel">Pilih SBP</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="sbpModalBody">
                    @include('lpt.partials.sbp-table')
                </div>
            </div>
        </div>
    </div>


    {{-- Lightbox --}}
    <div class="upload-lightbox" id="lightbox">
        <button class="upload-lightbox-close" id="lightboxClose">&times;</button>
        <img src="" alt="preview" id="lightboxImg">
    </div>
@endsection

@push('scripts')
<style>
    /* ===== Dropzone ===== */
    .upload-dropzone {
        position: relative;
        border: 2px dashed #c4c9d0;
        border-radius: 8px;
        padding: 28px 16px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background-color 0.2s;
        background: transparent;
    }
    .upload-dropzone:hover,
    .upload-dropzone.dragover {
        border-color: var(--cui-primary, #321fdb);
        background-color: rgba(50, 31, 219, 0.03);
    }
    .upload-dropzone-input {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    .upload-dropzone-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 10px;
        border-radius: 50%;
        background: rgba(50, 31, 219, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: var(--cui-primary, #321fdb);
    }
    .upload-dropzone-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--cui-body-color, #4f5d73);
        margin-bottom: 2px;
    }
    .upload-dropzone-sub {
        font-size: 0.78rem;
        color: var(--cui-text-medium-emphasis, #9da5b1);
    }

    /* ===== Progress ===== */
    .upload-progress {
        display: none;
        margin-top: 12px;
    }
    .upload-progress.active {
        display: block;
    }
    .upload-progress-info {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
    }
    .upload-spinner {
        width: 14px;
        height: 14px;
        border: 2px solid #d8dbe0;
        border-top-color: var(--cui-primary, #321fdb);
        border-radius: 50%;
        animation: upload-spin 0.6s linear infinite;
    }
    @keyframes upload-spin {
        to { transform: rotate(360deg); }
    }
    .upload-progress-text {
        font-size: 0.78rem;
        color: var(--cui-text-medium-emphasis, #9da5b1);
    }
    .upload-progress-track {
        height: 4px;
        background: #ebedef;
        border-radius: 2px;
        overflow: hidden;
    }
    .upload-progress-fill {
        height: 100%;
        width: 0%;
        background: var(--cui-primary, #321fdb);
        border-radius: 2px;
        transition: width 0.2s;
    }

    /* ===== Preview Section ===== */
    .upload-preview {
        display: none;
        margin-top: 16px;
    }
    .upload-preview.active {
        display: block;
    }
    .upload-preview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 8px;
        margin-bottom: 12px;
        border-bottom: 1px solid #d8dbe0;
    }
    .upload-preview-title {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--cui-body-color, #4f5d73);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .upload-preview-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 22px;
        height: 22px;
        padding: 0 7px;
        border-radius: 11px;
        background: var(--cui-primary, #321fdb);
        color: #fff;
        font-size: 0.72rem;
        font-weight: 700;
    }
    .upload-preview-clear {
        font-size: 0.75rem;
        color: #e55353;
        background: transparent;
        border: 1px solid #e55353;
        padding: 3px 12px;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.15s, color 0.15s;
    }
    .upload-preview-clear:hover {
        background: #e55353;
        color: #fff;
    }

    /* ===== Photo Grid ===== */
    .upload-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 10px;
    }

    /* ===== Photo Tile ===== */
    .upload-tile {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #d8dbe0;
        background: #f8f9fa;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .upload-tile:hover {
        border-color: var(--cui-primary, #321fdb);
        box-shadow: 0 0 0 1px var(--cui-primary, #321fdb);
    }
    .upload-tile-img {
        width: 100%;
        aspect-ratio: 1;
        object-fit: cover;
        display: block;
        cursor: pointer;
    }
    .upload-tile-meta {
        padding: 5px 8px 6px;
        border-top: 1px solid #ebedef;
        background: #fff;
    }
    .upload-tile-name {
        display: block;
        font-size: 0.68rem;
        font-weight: 600;
        color: var(--cui-body-color, #4f5d73);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.4;
    }
    .upload-tile-size {
        font-size: 0.68rem;
        color: var(--cui-text-medium-emphasis, #9da5b1);
        line-height: 1.4;
    }

    /* Badge & Delete */
    .upload-tile-badge {
        position: absolute;
        top: 5px;
        left: 5px;
        font-size: 0.62rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 4px;
        background: rgba(46, 184, 92, 0.9);
        color: #fff;
        letter-spacing: 0.02em;
    }
    .upload-tile-del {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: none;
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        font-size: 14px;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        padding: 0;
        opacity: 0;
        transition: opacity 0.15s, background 0.15s;
    }
    .upload-tile:hover .upload-tile-del {
        opacity: 1;
    }
    .upload-tile-del:hover {
        background: rgba(229, 83, 83, 0.9);
    }

    /* ===== Lightbox ===== */
    .upload-lightbox {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: rgba(0, 0, 0, 0.85);
        justify-content: center;
        align-items: center;
    }
    .upload-lightbox.active {
        display: flex;
    }
    .upload-lightbox img {
        max-width: 90vw;
        max-height: 90vh;
        border-radius: 8px;
        box-shadow: 0 8px 40px rgba(0, 0, 0, 0.4);
    }
    .upload-lightbox-close {
        position: absolute;
        top: 16px;
        right: 24px;
        background: none;
        border: none;
        color: #fff;
        font-size: 2rem;
        cursor: pointer;
        line-height: 1;
        opacity: 0.8;
        transition: opacity 0.15s;
    }
    .upload-lightbox-close:hover {
        opacity: 1;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sbpModalBody = document.getElementById('sbpModalBody');

    // AJAX pagination for SBP modal
    sbpModalBody.addEventListener('click', function(e) {
        // Handle SBP selection
        const selectBtn = e.target.closest('.pilih-sbp-btn');
        if (selectBtn) {
            document.getElementById('sbp_id').value = selectBtn.dataset.id;
            document.getElementById('nomor_sbp_display').value = selectBtn.dataset.nomorSbp;
            // No need to prevent default or stop propagation, modal dismissal is handled by data attributes
            return;
        }

        // Handle pagination link click
        const pageLink = e.target.closest('.pagination a');
        if (pageLink) {
            e.preventDefault(); // Prevent full page reload
            const url = pageLink.getAttribute('href');

            // Add a loading indicator
            sbpModalBody.innerHTML = `<div class="d-flex justify-content-center align-items-center" style="height: 200px;"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>`;

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                sbpModalBody.innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching SBP page:', error);
                sbpModalBody.innerHTML = '<p class="text-center text-danger">Gagal memuat data. Silakan coba lagi.</p>';
            });
        }
    });

    // =========================================================
    // Photo Upload & Compression (Existing Script)
    // =========================================================
    const photoInput      = document.getElementById('photos');
    const dropzone        = document.getElementById('uploadDropzone');
    const progressWrap    = document.getElementById('uploadProgress');
    const progressFill    = document.getElementById('progressFill');
    const progressText    = document.getElementById('progressText');
    const previewSection  = document.getElementById('uploadPreview');
    const photoGrid       = document.getElementById('photoGrid');
    const photoCount      = document.getElementById('photoCount');
    const clearAllBtn     = document.getElementById('clearAllBtn');
    const submitBtn       = document.getElementById('submitBtn');
    const lightbox        = document.getElementById('lightbox');
    const lightboxImg     = document.getElementById('lightboxImg');
    const lightboxClose   = document.getElementById('lightboxClose');

    let processedFiles = [];

    const COMPRESS_OPTIONS = {
        maxSizeMB: 0.3,
        maxWidthOrHeight: 1200,
        useWebWorker: true,
        fileType: 'image/jpeg',
    };

    ['dragenter', 'dragover'].forEach(evt =>
        dropzone.addEventListener(evt, () => dropzone.classList.add('dragover'))
    );
    ['dragleave', 'drop'].forEach(evt =>
        dropzone.addEventListener(evt, () => dropzone.classList.remove('dragover'))
    );

    function formatSize(bytes) {
        if (bytes < 1024)        return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
    }

    function setSubmitLoading(loading) {
        submitBtn.disabled = loading;
        submitBtn.innerHTML = loading
            ? '<span class="spinner-border spinner-border-sm me-1"></span>Mengompres...'
            : '<i class="cil-save me-1"></i>Simpan';
    }

    function syncInputFiles() {
        const dt = new DataTransfer();
        processedFiles.forEach(f => dt.items.add(f));
        photoInput.files = dt.files;
    }

    function updatePreview() {
        photoGrid.innerHTML = '';

        if (!processedFiles.length) {
            previewSection.classList.remove('active');
            return;
        }

        previewSection.classList.add('active');
        photoCount.textContent = processedFiles.length;

        processedFiles.forEach((file, idx) => {
            const url = URL.createObjectURL(file);
            const tile = document.createElement('div');
            tile.className = 'upload-tile';
            tile.innerHTML =
                '<button type="button" class="upload-tile-del" data-idx="' + idx + '" title="Hapus">&times;</button>' +
                (file._compressed
                    ? '<span class="upload-tile-badge">Dikompres</span>'
                    : '') +
                '<img src="' + url + '" class="upload-tile-img" data-url="' + url + '" alt="' + file.name + '">' +
                '<div class="upload-tile-meta">' +
                    '<span class="upload-tile-name" title="' + file.name + '">' + file.name + '</span>' +
                    '<span class="upload-tile-size">' + formatSize(file.size) + '</span>' +
                '</div>';
            photoGrid.appendChild(tile);
        });
    }

    photoGrid.addEventListener('click', function (e) {
        const delBtn = e.target.closest('.upload-tile-del');
        if (delBtn) {
            processedFiles.splice(parseInt(delBtn.dataset.idx), 1);
            syncInputFiles();
            updatePreview();
            if (!processedFiles.length) return;
        }

        const img = e.target.closest('.upload-tile-img');
        if (img) {
            lightboxImg.src = img.dataset.url;
            lightbox.classList.add('active');
        }
    });

    clearAllBtn.addEventListener('click', function () {
        processedFiles = [];
        syncInputFiles();
        updatePreview();
    });

    lightboxClose.addEventListener('click', () => lightbox.classList.remove('active'));
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) lightbox.classList.remove('active');
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') lightbox.classList.remove('active');
    });

    photoInput.addEventListener('change', async function () {
        const files = Array.from(this.files);
        if (!files.length) return;

        processedFiles = [];
        photoGrid.innerHTML = '';
        progressWrap.classList.add('active');
        progressFill.style.width = '0%';
        setSubmitLoading(true);

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            progressFill.style.width = Math.round((i / files.length) * 100) + '%';
            progressText.textContent = 'Memproses ' + (i + 1) + ' dari ' + files.length + ': ' + file.name;

            if (file.size > 300 * 1024) {
                try {
                    const compressed = await imageCompression(file, COMPRESS_OPTIONS);
                    const newFile = new File([compressed], file.name, {
                        type: compressed.type,
                        lastModified: Date.now(),
                    });
                    newFile._compressed = true;
                    processedFiles.push(newFile);
                } catch (err) {
                    console.error('Compress error:', file.name, err);
                    processedFiles.push(file);
                }
            } else {
                processedFiles.push(file);
            }
        }

        progressFill.style.width = '100%';
        syncInputFiles();
        setTimeout(() => progressWrap.classList.remove('active'), 300);

        updatePreview();
        setSubmitLoading(false);
    });
});
</script>
@endpush
