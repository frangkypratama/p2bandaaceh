@extends('layouts.app')

@section('title', 'Data LPT')

@section('content')
<style>
    #pdf-viewer-container {
        background-color: #525252;
        overflow-y: auto;
        position: relative;
        height: 75vh;
    }
    .pdf-page-wrapper {
        display: flex;
        justify-content: center;
        padding: 10px 0;
        position: relative;
    }
    .pdf-page-wrapper canvas {
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        background: white;
    }
    .pdf-text-layer {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        overflow: hidden;
        opacity: 0.25;
        line-height: 1.0;
        pointer-events: none;
    }
    .pdf-text-layer span {
        color: transparent;
        position: absolute;
        white-space: pre;
        transform-origin: 0% 0%;
        pointer-events: all;
    }
    .pdf-text-layer .highlight {
        background-color: #FFFF00;
        opacity: 1;
        border-radius: 2px;
    }
    .pdf-text-layer .highlight.active {
        background-color: #FF8C00;
    }
    #pdfLoading {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #525252;
        z-index: 10;
    }
    .pdf-toolbar {
        background-color: #f8f9fa;
        padding: 8px 12px;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
    #searchBar {
        background-color: #fff3cd;
        padding: 8px 12px;
        border-bottom: 1px solid #dee2e6;
        display: none;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
    #searchBar.active {
        display: flex;
    }
</style>

<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>Data Laporan Pelaksanaan Tugas (LPT)</strong>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#lptModal">
                            <i class="cil-plus me-2"></i>
                            Buat LPT
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nomor LPT</th>
                                    <th scope="col">Tanggal LPT</th>
                                    <th scope="col">Nomor SBP</th>
                                    <th scope="col">Jenis LPT</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lpt as $item)
                                    <tr>
                                        <td>{{ $item->nomor_lpt }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_lpt)->isoFormat('D MMMM Y') }}</td>
                                        <td>
                                            <span class="badge bg-info text-white">{{ $item->sbp?->nomor_sbp ?? 'N/A' }}</span>
                                        </td>
                                        <td>{{ $jenis_lpt_options[$item->jenis_lpt]['name'] ?? 'N/A' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info text-white preview-btn"
                                                    data-pdf-url="{{ route('lpt.preview', $item->id) }}"
                                                    data-pdf-title="{{ $item->nomor_lpt }}">
                                                <i class="cil-magnifying-glass"></i>
                                            </button>
                                            <a href="{{ route('lpt.edit', $item->id) }}" class="btn btn-sm btn-warning text-white">
                                                <i class="cil-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger"
                                                    data-coreui-toggle="modal"
                                                    data-coreui-target="#deleteConfirmationModal"
                                                    data-url="{{ route('lpt.destroy', $item->id) }}">
                                                <i class="cil-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data untuk ditampilkan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $lpt->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create LPT Modal -->
<div class="modal fade" id="lptModal" tabindex="-1" aria-labelledby="lptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lptModalLabel">Pilih Jenis LPT</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    @foreach($jenis_lpt_options as $key => $options)
                        <a href="{{ route('lpt.create', ['jenis' => $key]) }}" class="list-group-item list-group-item-action">
                            <i class="{{ $options['icon'] }} me-2"></i>{{ $options['name'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal (PDF.js) -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            {{-- Modal Header --}}
            <div class="modal-header py-2">
                <h5 class="modal-title" id="previewModalLabel">
                    <i class="cil-file me-1"></i> Preview LPT
                </h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Tutup"></button>
            </div>

            {{-- Card di dalam modal --}}
            <div class="modal-body p-0">
                <div class="card mb-0 border-0 rounded-0">

                    {{-- Toolbar PDF Viewer --}}
                    <div class="pdf-toolbar">
                        <div class="input-group input-group-sm" style="width: auto;">
                            <span class="input-group-text">Hal.</span>
                            <input type="number" class="form-control text-center" id="pageNumInput" value="1" min="1" style="width: 50px;">
                            <span class="input-group-text" id="pageCount">/ -</span>
                        </div>

                        <div class="vr mx-1 d-none d-sm-block"></div>

                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-light" id="zoomOut" title="Perkecil"><i class="cil-zoom-out"></i></button>
                        </div>
                        <span class="badge bg-light text-dark border" id="zoomLevel" style="min-width: 50px;">150%</span>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-light" id="zoomIn" title="Perbesar"><i class="cil-zoom-in"></i></button>
                        </div>

                        <div class="vr mx-1 d-none d-sm-block"></div>

                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-light" id="rotateCcw" title="Putar Kiri">
                                <i class="cil-action-undo"></i>
                            </button>
                            <button class="btn btn-light" id="rotateCw" title="Putar Kanan">
                                <i class="cil-action-redo"></i>
                            </button>
                        </div>

                        <div class="vr mx-1 d-none d-sm-block"></div>

                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-light" id="searchToggle" title="Cari Teks (Ctrl+F)">
                                <i class="cil-search"></i> <span class="d-none d-md-inline">Cari</span>
                            </button>
                        </div>

                        <div class="ms-auto"></div>

                        <div class="btn-group btn-group-sm">
                            <a href="#" id="downloadBtn" target="_blank" class="btn btn-light" title="Unduh PDF">
                                <i class="cil-data-transfer-down"></i> <span class="d-none d-md-inline">Unduh</span>
                            </a>
                            <button class="btn btn-light" id="printBtn" title="Cetak">
                                <i class="cil-print"></i> <span class="d-none d-md-inline">Cetak</span>
                            </button>
                        </div>
                    </div>

                    {{-- Search Bar --}}
                    <div id="searchBar">
                        <div class="input-group input-group-sm" style="max-width: 300px;">
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari teks...">
                            <button class="btn btn-outline-secondary" id="searchPrev" title="Sebelumnya">
                                <i class="cil-chevron-left"></i>
                            </button>
                            <button class="btn btn-outline-secondary" id="searchNext" title="Berikutnya">
                                <i class="cil-chevron-right"></i>
                            </button>
                        </div>
                        <span class="badge bg-secondary" id="searchResult" style="min-width: 60px;">0 / 0</span>
                        <button class="btn btn-sm btn-close ms-auto" id="searchClose" aria-label="Tutup"></button>
                    </div>

                    {{-- PDF Scroll Area --}}
                    <div id="pdf-viewer-container">
                        <div id="pdfLoading">
                            <div class="text-center text-white">
                                <div class="spinner-border text-light mb-2" role="status"></div>
                                <p class="mb-0">Memuat dokumen PDF...</p>
                            </div>
                        </div>
                        <div id="pdfError" style="display: none;"></div>
                        <div id="pdfPages"></div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    pdfjsLib.GlobalWorkerOptions.workerSrc =
        'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    // Elements
    var container    = document.getElementById('pdf-viewer-container');
    var pagesDiv     = document.getElementById('pdfPages');
    var loadingEl    = document.getElementById('pdfLoading');
    var errorEl      = document.getElementById('pdfError');
    var pageNumInput = document.getElementById('pageNumInput');
    var pageCountEl  = document.getElementById('pageCount');
    var zoomInBtn    = document.getElementById('zoomIn');
    var zoomOutBtn   = document.getElementById('zoomOut');
    var zoomLevelEl  = document.getElementById('zoomLevel');
    var rotateCwBtn  = document.getElementById('rotateCw');
    var rotateCcwBtn = document.getElementById('rotateCcw');
    var printBtn     = document.getElementById('printBtn');
    var downloadBtn  = document.getElementById('downloadBtn');
    var modalTitle   = document.getElementById('previewModalLabel');

    var searchToggle = document.getElementById('searchToggle');
    var searchBar    = document.getElementById('searchBar');
    var searchInput  = document.getElementById('searchInput');
    var searchPrevEl = document.getElementById('searchPrev');
    var searchNextEl = document.getElementById('searchNext');
    var searchResult = document.getElementById('searchResult');
    var searchClose  = document.getElementById('searchClose');

    var previewModalEl = document.getElementById('previewModal');

    // State
    var pdfDoc       = null;
    var currentUrl   = '';
    var scale        = 1.5;
    var rotation     = 0;
    var pageWrappers = [];
    var pageTextData = [];

    var searchMatches   = [];
    var currentMatchIdx = -1;
    var lastSearchTerm  = '';

    // ==========================================
    // HELPERS
    // ==========================================
    function hideLoading() {
        if (loadingEl) loadingEl.style.display = 'none';
    }

    function showLoading() {
        if (loadingEl) loadingEl.style.display = 'flex';
        errorEl.style.display  = 'none';
        pagesDiv.style.display = 'block';
        pagesDiv.innerHTML     = '';
    }

    function showError(msg) {
        hideLoading();
        pagesDiv.style.display = 'none';
        errorEl.style.display  = 'block';
        errorEl.innerHTML = '<div class="alert alert-danger text-center m-3">' +
            '<strong>Gagal memuat PDF</strong><br>' + msg +
            '<br><br><a href="' + currentUrl + '" target="_blank" class="btn btn-sm btn-outline-danger">Coba Buka Langsung</a>' +
            '</div>';
    }

    function updateZoomLabel() {
        zoomLevelEl.textContent = Math.round(scale * 100) + '%';
    }

    function resetViewer() {
        if (pdfDoc) {
            pdfDoc.destroy();
            pdfDoc = null;
        }
        currentUrl      = '';
        scale           = 1.5;
        rotation        = 0;
        pageWrappers    = [];
        pageTextData    = [];
        searchMatches   = [];
        currentMatchIdx = -1;
        lastSearchTerm  = '';
        pagesDiv.innerHTML = '';
        pagesDiv.style.display = 'block';
        pageNumInput.value = 1;
        pageCountEl.textContent = '/ -';
        updateZoomLabel();
        searchBar.classList.remove('active');
        searchInput.value = '';
        searchResult.textContent = '0 / 0';
        searchResult.className = 'badge bg-secondary';
        errorEl.style.display = 'none';
        downloadBtn.href = '#';
    }

    // ==========================================
    // TEXT LAYER
    // ==========================================
    function buildTextLayer(wrapper, textContent, viewport) {
        var old = wrapper.querySelector('.pdf-text-layer');
        if (old) old.remove();

        var canvas = wrapper.querySelector('canvas');
        var textLayer = document.createElement('div');
        textLayer.className = 'pdf-text-layer';
        textLayer.style.width  = canvas.width + 'px';
        textLayer.style.height = canvas.height + 'px';

        var canvasRect  = canvas.getBoundingClientRect();
        var wrapperRect = wrapper.getBoundingClientRect();
        textLayer.style.left = (canvasRect.left - wrapperRect.left) + 'px';
        textLayer.style.top  = (canvasRect.top - wrapperRect.top) + 'px';

        var items = textContent.items;
        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            if (!item.str || item.str.trim() === '') continue;

            var tx = pdfjsLib.Util.transform(viewport.transform, item.transform);
            var span = document.createElement('span');
            span.textContent = item.str;
            span.setAttribute('data-item-index', i);

            var fontSize = Math.sqrt(tx[2] * tx[2] + tx[3] * tx[3]);
            var angle = Math.atan2(tx[1], tx[0]);

            span.style.left     = tx[4] + 'px';
            span.style.top      = (tx[5] - fontSize) + 'px';
            span.style.fontSize = fontSize + 'px';
            span.style.fontFamily = item.fontName || 'sans-serif';

            if (angle !== 0) {
                span.style.transform = 'rotate(' + angle + 'rad)';
            }
            if (item.width) {
                span.style.letterSpacing = ((item.width * scale / item.str.length) - fontSize * 0.5) + 'px';
            }

            textLayer.appendChild(span);
        }

        wrapper.appendChild(textLayer);
    }

    // ==========================================
    // RENDER
    // ==========================================
    function renderPageToCanvas(page, canvas) {
        var totalRotation = (page.rotate + rotation) % 360;
        var viewport = page.getViewport({ scale: scale, rotation: totalRotation });
        canvas.height = viewport.height;
        canvas.width  = viewport.width;
        var ctx = canvas.getContext('2d');

        return page.render({
            canvasContext: ctx,
            viewport: viewport
        }).promise.then(function() {
            return page.getTextContent();
        }).then(function(textContent) {
            return { textContent: textContent, viewport: viewport };
        });
    }

    function renderAllPages() {
        if (!pdfDoc) return;

        var scrollRatio = 0;
        if (container.scrollHeight > container.clientHeight) {
            scrollRatio = container.scrollTop / (container.scrollHeight - container.clientHeight);
        }

        pagesDiv.innerHTML = '';
        pageWrappers = [];
        pageTextData = [];

        var totalPages = pdfDoc.numPages;
        pageCountEl.textContent = '/ ' + totalPages;
        pageNumInput.max = totalPages;
        updateZoomLabel();

        for (var i = 1; i <= totalPages; i++) {
            var wrapper = document.createElement('div');
            wrapper.className = 'pdf-page-wrapper';
            wrapper.setAttribute('data-page', i);

            var canvas = document.createElement('canvas');
            wrapper.appendChild(canvas);
            pagesDiv.appendChild(wrapper);
            pageWrappers.push(wrapper);
            pageTextData.push(null);
        }

        var renderChain = Promise.resolve();
        for (var p = 1; p <= totalPages; p++) {
            (function(pageNum) {
                renderChain = renderChain.then(function() {
                    return pdfDoc.getPage(pageNum);
                }).then(function(page) {
                    var canvas = pageWrappers[pageNum - 1].querySelector('canvas');
                    return renderPageToCanvas(page, canvas);
                }).then(function(result) {
                    pageTextData[pageNum - 1] = result;
                    buildTextLayer(pageWrappers[pageNum - 1], result.textContent, result.viewport);
                });
            })(p);
        }

        renderChain.then(function() {
            hideLoading();
            if (scrollRatio > 0) {
                container.scrollTop = scrollRatio * (container.scrollHeight - container.clientHeight);
            }
            if (lastSearchTerm) {
                performSearch(lastSearchTerm);
            }
        }).catch(function(err) {
            hideLoading();
            console.error('Render error:', err);
        });
    }

    // ==========================================
    // SEARCH
    // ==========================================
    function clearHighlights() {
        var highlighted = pagesDiv.querySelectorAll('.highlight');
        for (var i = 0; i < highlighted.length; i++) {
            highlighted[i].classList.remove('highlight', 'active');
        }
        searchMatches   = [];
        currentMatchIdx = -1;
        searchResult.textContent = '0 / 0';
    }

    function performSearch(term) {
        clearHighlights();
        if (!term || term.trim() === '') {
            lastSearchTerm = '';
            searchResult.className = 'badge bg-secondary';
            return;
        }

        lastSearchTerm = term;
        var lowerTerm = term.toLowerCase();

        for (var p = 0; p < pageTextData.length; p++) {
            if (!pageTextData[p]) continue;

            var items = pageTextData[p].textContent.items;
            var textLayer = pageWrappers[p].querySelector('.pdf-text-layer');
            if (!textLayer) continue;

            for (var i = 0; i < items.length; i++) {
                var str = items[i].str;
                if (!str) continue;

                if (str.toLowerCase().indexOf(lowerTerm) !== -1) {
                    var spans = textLayer.querySelectorAll('span[data-item-index="' + i + '"]');
                    for (var s = 0; s < spans.length; s++) {
                        spans[s].classList.add('highlight');
                        searchMatches.push({ pageIndex: p, element: spans[s] });
                    }
                }
            }
        }

        if (searchMatches.length > 0) {
            currentMatchIdx = 0;
            activateMatch(0);
        }
        updateSearchResult();
    }

    function activateMatch(idx) {
        var prev = pagesDiv.querySelector('.highlight.active');
        if (prev) prev.classList.remove('active');

        if (idx < 0 || idx >= searchMatches.length) return;

        var match = searchMatches[idx];
        match.element.classList.add('active');
        match.element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        pageNumInput.value = match.pageIndex + 1;
    }

    function updateSearchResult() {
        if (!lastSearchTerm) {
            searchResult.textContent = '0 / 0';
            searchResult.className = 'badge bg-secondary';
        } else if (searchMatches.length === 0) {
            searchResult.textContent = '0 / 0';
            searchResult.className = 'badge bg-danger';
        } else {
            searchResult.textContent = (currentMatchIdx + 1) + ' / ' + searchMatches.length;
            searchResult.className = 'badge bg-success';
        }
    }

    function searchNextMatch() {
        if (searchMatches.length === 0) return;
        currentMatchIdx = (currentMatchIdx + 1) % searchMatches.length;
        activateMatch(currentMatchIdx);
        updateSearchResult();
    }

    function searchPrevMatch() {
        if (searchMatches.length === 0) return;
        currentMatchIdx = (currentMatchIdx - 1 + searchMatches.length) % searchMatches.length;
        activateMatch(currentMatchIdx);
        updateSearchResult();
    }

    // ==========================================
    // SCROLL DETECTION
    // ==========================================
    function getCurrentVisiblePage() {
        var containerRect = container.getBoundingClientRect();
        var containerMid  = containerRect.top + containerRect.height / 2;
        var closest = 1;
        var closestDist = Infinity;

        for (var i = 0; i < pageWrappers.length; i++) {
            var rect = pageWrappers[i].getBoundingClientRect();
            var pageMid = rect.top + rect.height / 2;
            var dist = Math.abs(pageMid - containerMid);
            if (dist < closestDist) {
                closestDist = dist;
                closest = i + 1;
            }
        }
        return closest;
    }

    var scrollTimeout;
    container.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(function() {
            pageNumInput.value = getCurrentVisiblePage();
        }, 100);
    });

    // ==========================================
    // LOAD PDF
    // ==========================================
    function loadPdf(url) {
        currentUrl = url;
        showLoading();
        downloadBtn.href = url;

        pdfjsLib.getDocument({
            url: url,
            withCredentials: true
        }).promise.then(function(doc) {
            pdfDoc = doc;
            renderAllPages();
        }).catch(function(err) {
            showError(err.message || 'Tidak dapat memuat dokumen.');
            console.error('PDF load error:', err);
        });
    }

    // ==========================================
    // EVENT LISTENERS
    // ==========================================

    pageNumInput.addEventListener('change', function() {
        var num = parseInt(this.value, 10);
        if (pdfDoc && num >= 1 && num <= pdfDoc.numPages && pageWrappers[num - 1]) {
            pageWrappers[num - 1].scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            this.value = getCurrentVisiblePage();
        }
    });

    zoomInBtn.addEventListener('click', function() {
        if (!pdfDoc || scale >= 4) return;
        scale = Math.round((scale + 0.25) * 100) / 100;
        renderAllPages();
    });
    zoomOutBtn.addEventListener('click', function() {
        if (!pdfDoc || scale <= 0.5) return;
        scale = Math.round((scale - 0.25) * 100) / 100;
        renderAllPages();
    });

    rotateCwBtn.addEventListener('click', function() {
        if (!pdfDoc) return;
        rotation = (rotation + 90) % 360;
        renderAllPages();
    });
    rotateCcwBtn.addEventListener('click', function() {
        if (!pdfDoc) return;
        rotation = (rotation - 90 + 360) % 360;
        renderAllPages();
    });

    printBtn.addEventListener('click', function() {
        if (!currentUrl) return;
        var w = window.open(currentUrl);
        if (w) {
            w.addEventListener('load', function() { w.print(); });
        } else {
            window.open(currentUrl, '_blank');
        }
    });

    searchToggle.addEventListener('click', function() {
        searchBar.classList.toggle('active');
        if (searchBar.classList.contains('active')) {
            searchInput.focus();
        } else {
            clearHighlights();
            searchInput.value = '';
            lastSearchTerm = '';
        }
    });

    searchClose.addEventListener('click', function() {
        searchBar.classList.remove('active');
        clearHighlights();
        searchInput.value = '';
        lastSearchTerm = '';
    });

    var searchDebounce;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchDebounce);
        var term = this.value;
        searchDebounce = setTimeout(function() {
            performSearch(term);
        }, 300);
    });

    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            if (e.shiftKey) { searchPrevMatch(); } else { searchNextMatch(); }
        }
        if (e.key === 'Escape') { searchClose.click(); }
    });

    searchNextEl.addEventListener('click', searchNextMatch);
    searchPrevEl.addEventListener('click', searchPrevMatch);

    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            if (previewModalEl.classList.contains('show')) {
                e.preventDefault();
                searchBar.classList.add('active');
                searchInput.focus();
                searchInput.select();
            }
            return;
        }
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
        if (e.key === '+' || e.key === '=') zoomInBtn.click();
        if (e.key === '-') zoomOutBtn.click();
    });

    // ==========================================
    // PREVIEW BUTTONS
    // ==========================================
    document.querySelectorAll('.preview-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var url   = this.getAttribute('data-pdf-url');
            var title = this.getAttribute('data-pdf-title');
            var modal = new coreui.Modal(previewModalEl);

            resetViewer();

            // Update judul modal
            modalTitle.innerHTML = 'Preview ' + (title || 'LPT');

            modal.show();

            previewModalEl.addEventListener('shown.coreui.modal', function onShown() {
                previewModalEl.removeEventListener('shown.coreui.modal', onShown);
                loadPdf(url);
            });
        });
    });

    // Reset saat modal ditutup
    previewModalEl.addEventListener('hidden.coreui.modal', function() {
        resetViewer();
    });

});
</script>
@endsection