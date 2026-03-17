@extends('layouts.app')

@section('content')

{{-- Styles for PDF Viewer --}}
<style>
    #cetakModal .pdf-viewer-container {
        background-color: #525252;
        overflow-y: auto;
        position: relative;
        height: 70vh;
    }
    #cetakModal .pdf-page-wrapper {
        display: flex;
        justify-content: center;
        padding: 10px 0;
    }
    #cetakModal .pdf-page-wrapper canvas {
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        background: white;
    }
    #cetakModal .pdf-loading {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 10;
        color: white;
    }
    #cetakModal .pdf-toolbar {
        background-color: #f8f9fa;
        padding: 8px 12px;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
</style>

<div class="container-lg">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><strong>Data Pemeriksaan Badan</strong></h5>
            <a href="{{ route('pemeriksaan-badan.create') }}" class="btn btn-primary">
                <i class="cil-plus"></i> Tambah Data
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No BA Riksa Badan</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Identitas</th>
                            <th class="text-center">Kewarganegaraan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pemeriksaanBadan as $item)
                            <tr>
                                <td class="text-center">{{ $item->no_ba_riksa }}</td>
                                <td class="text-center">{{ $item->nama }}</td>
                                <td class="text-center">{{ $item->jenis_identitas }} / {{ $item->no_identitas }}</td>
                                <td class="text-center">{{ $item->kewarganegaraan }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2" role="group" aria-label="Aksi">
                                        <button type="button" class="btn btn-info btn-sm btn-preview"
                                            data-coreui-toggle="modal"
                                            data-coreui-target="#cetakModal"
                                            data-preview-url="{{ route('pemeriksaan-badan.cetak', [$item->id, 'is_preview' => true]) }}"
                                            data-download-url="{{ route('pemeriksaan-badan.cetak', $item->id) }}">
                                            <i class="cil-search"></i>
                                        </button>
                                        <a href="{{ route('pemeriksaan-badan.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="cil-pencil"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                                data-coreui-toggle="modal"
                                                data-coreui-target="#deleteConfirmationModal"
                                                data-url="{{ route('pemeriksaan-badan.destroy', $item->id) }}">
                                            <i class="cil-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($pemeriksaanBadan->hasPages())
                <div class="mt-3">
                    {{ $pemeriksaanBadan->links('vendor.pagination.coreui') }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal with PDF.js Viewer --}}
<div class="modal fade" id="cetakModal" tabindex="-1" aria-labelledby="cetakModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cetakModalLabel">Preview Dokumen</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                
                {{-- PDF Viewer Toolbar --}}
                <div class="pdf-toolbar">
                    <div class="input-group input-group-sm" style="width: auto;">
                        <span class="input-group-text">Hal.</span>
                        <input type="number" class="form-control text-center pdf-page-num" value="1" min="1" style="width: 50px;">
                        <span class="input-group-text pdf-page-count">/ -</span>
                    </div>

                    <div class="vr mx-1 d-none d-sm-block"></div>

                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-light pdf-zoom-out" title="Perkecil"><i class="cil-zoom-out"></i></button>
                    </div>
                    <span class="badge bg-light text-dark border pdf-zoom-level" style="min-width: 50px;">100%</span>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-light pdf-zoom-in" title="Perbesar"><i class="cil-zoom-in"></i></button>
                    </div>

                    <div class="vr mx-1 d-none d-sm-block"></div>

                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-light pdf-rotate-ccw" title="Putar Kiri"><i class="cil-action-undo"></i></button>
                        <button class="btn btn-light pdf-rotate-cw" title="Putar Kanan"><i class="cil-action-redo"></i></button>
                    </div>

                    <div class="ms-auto"></div>

                    <div class="btn-group btn-group-sm">
                        <a href="#" target="_blank" class="btn btn-light pdf-download" title="Unduh PDF">
                            <i class="cil-data-transfer-down"></i> <span class="d-none d-md-inline">Unduh</span>
                        </a>
                        <button type="button" class="btn btn-light pdf-print" title="Cetak PDF">
                            <i class="cil-print"></i> <span class="d-none d-md-inline">Cetak</span>
                        </button>
                    </div>
                </div>

                {{-- PDF Scroll Area --}}
                <div class="pdf-viewer-container">
                    <div class="pdf-loading">
                        <div class="text-center">
                            <div class="spinner-border text-light mb-2" role="status"></div>
                            <p class="mb-0">Memuat dokumen PDF...</p>
                        </div>
                    </div>
                    <div class="pdf-error" style="display: none;"></div>
                    <div class="pdf-pages"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    const modalEl = document.getElementById('cetakModal');
    if (!modalEl) return;

    let pdfDoc = null;
    let scale = 1.5;
    let rotation = 0;
    let pageWrappers = [];
    let currentUrl = null;

    const container = modalEl.querySelector('.pdf-viewer-container');
    const pagesDiv = modalEl.querySelector('.pdf-pages');
    const loadingEl = modalEl.querySelector('.pdf-loading');
    const errorEl = modalEl.querySelector('.pdf-error');
    const pageNumInput = modalEl.querySelector('.pdf-page-num');
    const pageCountEl = modalEl.querySelector('.pdf-page-count');
    const zoomInBtn = modalEl.querySelector('.pdf-zoom-in');
    const zoomOutBtn = modalEl.querySelector('.pdf-zoom-out');
    const zoomLevelEl = modalEl.querySelector('.pdf-zoom-level');
    const rotateCwBtn = modalEl.querySelector('.pdf-rotate-cw');
    const rotateCcwBtn = modalEl.querySelector('.pdf-rotate-ccw');
    const downloadBtn = modalEl.querySelector('.pdf-download');
    const printBtn = modalEl.querySelector('.pdf-print');

    function showLoading(show = true) {
        loadingEl.style.display = show ? 'flex' : 'none';
    }

    function showError(msg, url) {
        showLoading(false);
        pagesDiv.style.display = 'none';
        errorEl.style.display = 'block';
        errorEl.innerHTML = `<div class="alert alert-danger text-center m-3">
            <strong>Gagal memuat PDF</strong><br>${msg}<br><br>
            <a href="${url}" target="_blank" class="btn btn-sm btn-outline-danger">Coba Buka Langsung</a>
            </div>`;
    }

    function updateZoomLabel() {
        zoomLevelEl.textContent = Math.round(scale * 100) + '%';
    }
    
    async function renderAllPages() {
        if (!pdfDoc) return;

        pagesDiv.innerHTML = '';
        pageWrappers = [];
        pageCountEl.textContent = `/ ${pdfDoc.numPages}`;
        pageNumInput.max = pdfDoc.numPages;
        updateZoomLabel();
        showLoading(true);
        
        try {
            for (let i = 1; i <= pdfDoc.numPages; i++) {
                const page = await pdfDoc.getPage(i);
                const totalRotation = (page.rotate + rotation) % 360;
                const viewport = page.getViewport({ scale, rotation: totalRotation });
                
                const wrapper = document.createElement('div');
                wrapper.className = 'pdf-page-wrapper';
                
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                wrapper.appendChild(canvas);
                pagesDiv.appendChild(wrapper);
                pageWrappers.push(wrapper);

                await page.render({ canvasContext: ctx, viewport }).promise;
            }
        } catch (err) {
            console.error('Render error:', err);
            showError(err.message, currentUrl);
        } finally {
            showLoading(false);
        }
    }

    function cleanup() {
        if (pdfDoc) {
            pdfDoc.destroy();
            pdfDoc = null;
        }
        pagesDiv.innerHTML = '';
        pageWrappers = [];
        scale = 1.5;
        rotation = 0;
        currentUrl = null;
        errorEl.style.display = 'none';
        pagesDiv.style.display = 'block';
        pageNumInput.value = 1;
        pageCountEl.textContent = '/ -';
    }

    async function loadPdfInModal(url) {
        cleanup();
        currentUrl = url;
        showLoading(true);

        try {
            pdfDoc = await pdfjsLib.getDocument({ url, withCredentials: true }).promise;
            await renderAllPages();
        } catch (err) {
            console.error('PDF load error:', err);
            showError(err.message, url);
        }
    }
    
    zoomInBtn.addEventListener('click', () => {
        if (scale >= 4) return;
        scale = Math.round((scale + 0.25) * 100) / 100;
        renderAllPages();
    });

    zoomOutBtn.addEventListener('click', () => {
        if (scale <= 0.5) return;
        scale = Math.round((scale - 0.25) * 100) / 100;
        renderAllPages();
    });

    rotateCwBtn.addEventListener('click', () => {
        rotation = (rotation + 90) % 360;
        renderAllPages();
    });

    rotateCcwBtn.addEventListener('click', () => {
        rotation = (rotation - 90 + 360) % 360;
        renderAllPages();
    });

    printBtn.addEventListener('click', () => {
        if (!currentUrl) return;
        const printWindow = window.open(currentUrl, '_blank');
        if (printWindow) {
            printWindow.addEventListener('load', () => {
                printWindow.print();
            });
        }
    });
    
    pageNumInput.addEventListener('change', function() {
        const num = parseInt(this.value, 10);
        if (pdfDoc && num >= 1 && num <= pdfDoc.numPages && pageWrappers[num - 1]) {
            pageWrappers[num - 1].scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
    
    modalEl.addEventListener('show.coreui.modal', function (event) {
        const button = event.relatedTarget;
        const previewUrl = button.getAttribute('data-preview-url');
        const downloadUrl = button.getAttribute('data-download-url');
        
        downloadBtn.href = downloadUrl;
        
        loadPdfInModal(previewUrl);
    });

    modalEl.addEventListener('hidden.coreui.modal', function () {
        cleanup();
    });
});
</script>
@endpush