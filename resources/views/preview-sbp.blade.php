@extends('layouts.app')

@section('title', 'Pratinjau Dokumen ' . $sbp->nomor_sbp)

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
    /* Text layer untuk highlight search */
    .pdf-text-layer {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
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
    <div class="card d-print-none">

        {{-- Header --}}
        <div class="card-header">
            <strong>Pratinjau {{ $sbp->nomor_sbp }}</strong>
        </div>

        {{-- Toolbar Cetak + Kembali --}}
        <div class="pdf-toolbar">
            <a href="{{ route('sbp.index') }}" class="btn btn-secondary">
                <i class="cil-arrow-circle-left"></i> Kembali
            </a>

            <div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-coreui-toggle="dropdown" aria-expanded="false">
                    <i class="cil-print"></i> Cetak Dokumen
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item fw-bold" href="{{ route('sbp.pdf.semua', $sbp->id) }}" target="_blank">Cetak Semua Dokumen</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('sbp.pdf', $sbp->id) }}" target="_blank">Cetak SBP</a></li>
                    <li><a class="dropdown-item" href="{{ route('sbp.pdf.ba-riksa', $sbp->id) }}" target="_blank">Cetak BA Pemeriksaan</a></li>
                    <li><a class="dropdown-item" href="{{ route('sbp.pdf.ba-tegah', $sbp->id) }}" target="_blank">Cetak BA Penegahan</a></li>
                    <li><a class="dropdown-item" href="{{ route('sbp.pdf.ba-segel', $sbp->id) }}" target="_blank">Cetak BA Penyegelan</a></li>
                    @if ($sbp->bast)
                    <li><a class="dropdown-item" href="{{ route('sbp.pdf.bast', $sbp->id) }}" target="_blank">Cetak BA Serah Terima</a></li>
                    @endif
                    @if ($sbp->flag_ba_musnah && $sbp->nomor_ba_musnah)
                    <li><a class="dropdown-item" href="{{ route('sbp.cetak.ba-musnah', $sbp->id) }}" target="_blank">Cetak BA Musnah</a></li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('sbp.pdf.checklist', $sbp->id) }}" target="_blank">Checklist Kelengkapan</a></li>
                </ul>
            </div>
        </div>

        {{-- Toolbar PDF Viewer --}}
        <div class="pdf-toolbar">
            {{-- Halaman --}}
            <div class="input-group input-group-sm" style="width: auto;">
                <span class="input-group-text">Hal.</span>
                <input type="number" class="form-control text-center" id="pageNumInput" value="1" min="1" style="width: 50px;">
                <span class="input-group-text" id="pageCount">/ -</span>
            </div>

            <div class="vr mx-1 d-none d-sm-block"></div>

            {{-- Zoom --}}
            <div class="btn-group btn-group-sm">
                <button class="btn btn-light" id="zoomOut" title="Perkecil"><i class="cil-zoom-out"></i></button>
            </div>
            <span class="badge bg-light text-dark border" id="zoomLevel" style="min-width: 50px;">100%</span>
            <div class="btn-group btn-group-sm">
                <button class="btn btn-light" id="zoomIn" title="Perbesar"><i class="cil-zoom-in"></i></button>
            </div>

            <div class="vr mx-1 d-none d-sm-block"></div>

            {{-- Rotasi --}}
            <div class="btn-group btn-group-sm">
                <button class="btn btn-light" id="rotateCcw" title="Putar Kiri">
                    <i class="cil-action-undo"></i>
                </button>
                <button class="btn btn-light" id="rotateCw" title="Putar Kanan">
                    <i class="cil-action-redo"></i>
                </button>
            </div>

            <div class="vr mx-1 d-none d-sm-block"></div>

            {{-- Search Toggle --}}
            <div class="btn-group btn-group-sm">
                <button class="btn btn-light" id="searchToggle" title="Cari Teks (Ctrl+F)">
                    <i class="cil-search"></i> <span class="d-none d-md-inline">Cari</span>
                </button>
            </div>

            <div class="ms-auto"></div>

            {{-- Unduh & Cetak --}}
            <div class="btn-group btn-group-sm">
                <a href="{{ route('sbp.pdf.semua', $sbp->id) }}" target="_blank" class="btn btn-light" title="Unduh PDF">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

<script>
(function() {
    'use strict';

    pdfjsLib.GlobalWorkerOptions.workerSrc =
        'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    var url = @json(route('sbp.pdf.semua', $sbp->id));

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

    // Search elements
    var searchToggle = document.getElementById('searchToggle');
    var searchBar    = document.getElementById('searchBar');
    var searchInput  = document.getElementById('searchInput');
    var searchPrev   = document.getElementById('searchPrev');
    var searchNext   = document.getElementById('searchNext');
    var searchResult = document.getElementById('searchResult');
    var searchClose  = document.getElementById('searchClose');

    // State
    var pdfDoc       = null;
    var scale        = 1.5;
    var rotation     = 0;
    var pageWrappers = [];
    var pageTextData = []; // cache teks tiap halaman { items, viewport }

    // Search state
    var searchMatches    = []; // { pageIndex, itemIndex, startPos }
    var currentMatchIdx  = -1;
    var lastSearchTerm   = '';

    function hideLoading() {
        if (loadingEl) loadingEl.style.display = 'none';
    }

    function showError(msg) {
        hideLoading();
        pagesDiv.style.display = 'none';
        errorEl.style.display  = 'block';
        errorEl.innerHTML = '<div class="alert alert-danger text-center m-3">' +
            '<strong>Gagal memuat PDF</strong><br>' + msg +
            '<br><br><a href="' + url + '" target="_blank" class="btn btn-sm btn-outline-danger">Coba Buka Langsung</a>' +
            '</div>';
    }

    function updateZoomLabel() {
        zoomLevelEl.textContent = Math.round(scale * 100) + '%';
    }

    // ==========================================
    // TEXT LAYER: render teks transparan di atas canvas
    // ==========================================
    function buildTextLayer(wrapper, textContent, viewport) {
        // Hapus text layer lama
        var old = wrapper.querySelector('.pdf-text-layer');
        if (old) old.remove();

        var canvas = wrapper.querySelector('canvas');
        var textLayer = document.createElement('div');
        textLayer.className = 'pdf-text-layer';
        textLayer.style.width  = canvas.width + 'px';
        textLayer.style.height = canvas.height + 'px';

        // Posisikan text layer tepat di atas canvas
        var canvasRect = canvas.getBoundingClientRect();
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
            // Re-apply search highlight jika ada
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
            var span = highlighted[i];
            span.classList.remove('highlight', 'active');
        }
        searchMatches   = [];
        currentMatchIdx = -1;
        searchResult.textContent = '0 / 0';
    }

    function performSearch(term) {
        clearHighlights();
        if (!term || term.trim() === '') {
            lastSearchTerm = '';
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
                    // Cari span yang sesuai
                    var spans = textLayer.querySelectorAll('span[data-item-index="' + i + '"]');
                    for (var s = 0; s < spans.length; s++) {
                        spans[s].classList.add('highlight');
                        searchMatches.push({
                            pageIndex: p,
                            element: spans[s]
                        });
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
        // Hapus active sebelumnya
        var prev = pagesDiv.querySelector('.highlight.active');
        if (prev) prev.classList.remove('active');

        if (idx < 0 || idx >= searchMatches.length) return;

        var match = searchMatches[idx];
        match.element.classList.add('active');

        // Scroll ke halaman dan posisi match
        match.element.scrollIntoView({ behavior: 'smooth', block: 'center' });

        // Update nomor halaman
        pageNumInput.value = match.pageIndex + 1;
    }

    function updateSearchResult() {
        if (searchMatches.length === 0) {
            searchResult.textContent = '0 / 0';
            searchResult.className = 'badge bg-danger';
        } else {
            searchResult.textContent = (currentMatchIdx + 1) + ' / ' + searchMatches.length;
            searchResult.className = 'badge bg-success';
        }

        if (!lastSearchTerm) {
            searchResult.textContent = '0 / 0';
            searchResult.className = 'badge bg-secondary';
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
    // EVENT LISTENERS
    // ==========================================

    // Go to page
    pageNumInput.addEventListener('change', function() {
        var num = parseInt(this.value, 10);
        if (pdfDoc && num >= 1 && num <= pdfDoc.numPages && pageWrappers[num - 1]) {
            pageWrappers[num - 1].scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            this.value = getCurrentVisiblePage();
        }
    });

    // Zoom
    zoomInBtn.addEventListener('click', function() {
        if (scale >= 4) return;
        scale = Math.round((scale + 0.25) * 100) / 100;
        renderAllPages();
    });
    zoomOutBtn.addEventListener('click', function() {
        if (scale <= 0.5) return;
        scale = Math.round((scale - 0.25) * 100) / 100;
        renderAllPages();
    });

    // Rotasi
    rotateCwBtn.addEventListener('click', function() {
        rotation = (rotation + 90) % 360;
        renderAllPages();
    });
    rotateCcwBtn.addEventListener('click', function() {
        rotation = (rotation - 90 + 360) % 360;
        renderAllPages();
    });

    // Cetak
    printBtn.addEventListener('click', function() {
        var w = window.open(url);
        if (w) {
            w.addEventListener('load', function() { w.print(); });
        } else {
            window.open(url, '_blank');
        }
    });

    // Search toggle
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

    // Search close
    searchClose.addEventListener('click', function() {
        searchBar.classList.remove('active');
        clearHighlights();
        searchInput.value = '';
        lastSearchTerm = '';
    });

    // Search input
    var searchDebounce;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchDebounce);
        var term = this.value;
        searchDebounce = setTimeout(function() {
            performSearch(term);
        }, 300);
    });

    // Search Enter = next, Shift+Enter = prev
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            if (e.shiftKey) {
                searchPrevMatch();
            } else {
                searchNextMatch();
            }
        }
        if (e.key === 'Escape') {
            searchClose.click();
        }
    });

    searchNext.addEventListener('click', searchNextMatch);
    searchPrev.addEventListener('click', searchPrevMatch);

    // Keyboard global
    document.addEventListener('keydown', function(e) {
        // Ctrl+F = buka search
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            searchBar.classList.add('active');
            searchInput.focus();
            searchInput.select();
            return;
        }

        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
        if (e.key === '+' || e.key === '=') zoomInBtn.click();
        if (e.key === '-') zoomOutBtn.click();
    });

    // ==========================================
    // LOAD PDF
    // ==========================================
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

})();
</script>
@endsection