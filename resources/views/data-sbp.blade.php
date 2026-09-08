@extends('layouts.app')

@section('title', 'Data SBP')

@section('content')
<div class="container-lg">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><strong>Data Surat Bukti Penindakan (SBP)</strong></h5>
            <a href="{{ route('sbp.create') }}" class="btn btn-primary">
                <i class="cil-plus"></i>
                <span class="d-none d-md-inline">Tambah Data</span>
            </a>
        </div>
        <div class="card-body">
            <form id="filterForm" action="{{ route('sbp.index') }}" method="GET">
                <div class="row mb-3 align-items-center">
                    {{-- Filter Pencarian --}}
                    <div class="col-md-5 mb-2 mb-md-0">
                        <div class="input-group">
                            <span class="input-group-text"><i class="cil-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Cari nomor, pelaku, identitas..." value="{{ request('search') }}" autocomplete="off">
                        </div>
                    </div>
                    
                    {{-- Filter Tanggal --}}
                    <div class="col-md-4 mb-2 mb-md-0">
                        <div class="input-group">
                            <span class="input-group-text"><i class="cil-calendar"></i></span>
                            <input type="text" id="dateRangePicker" name="date_range" class="form-control" placeholder="Pilih rentang tanggal" value="{{ request('date_range') }}" autocomplete="off">
                            <span id="clearDateFilter" class="input-group-text" style="display: none; cursor: pointer;" title="Hapus filter tanggal">
                                <i class="cil-x"></i>
                            </span>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="col-md-3 d-flex justify-content-md-end">
                        <a id="downloadExcelBtn" href="{{ route('sbp.export.excel', request()->query()) }}" class="btn btn-success">
                            <i class="cil-cloud-download"></i>
                            <span class="d-none d-lg-inline">Download Excel</span>
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nomor SBP</th>
                            <th>Tanggal SBP</th>
                            <th>Pelaku</th>
                            <th>Identitas</th>
                            <th>Jenis Barang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sbpData as $sbp)
                            <tr>
                                <td>{{ $sbp->nomor_sbp }}</td>
                                <td>{{ \Carbon\Carbon::parse($sbp->tanggal_sbp)->translatedFormat('d F Y') }}</td>
                                <td>{{ $sbp->nama_pelaku }}</td>
                                <td>{{ $sbp->jenis_identitas }} / {{ $sbp->nomor_identitas }}</td>
                                <td>{{ $sbp->jenis_barang }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('sbp.cetak.preview', ['id' => $sbp->id, 'back' => request()->fullUrl()]) }}" class="btn btn-sm btn-info text-white me-2" title="Lihat Pratinjau">
                                            <i class="cil-print"></i>
                                        </a>
                                        <a href="{{ route('sbp.edit', $sbp->id) }}" class="btn btn-sm btn-warning text-white me-2" title="Edit Data">
                                            <i class="cil-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger text-white me-2"
                                                data-coreui-toggle="modal"
                                                data-coreui-target="#deleteConfirmationModal"
                                                data-url="{{ route('sbp.destroy', $sbp->id) }}"
                                                title="Hapus Data">
                                            <i class="cil-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="cil-warning" style="font-size: 2rem;"></i>
                                    <p class="mt-2 mb-1">Tidak ada data yang ditemukan.</p>
                                    <p class="text-muted">Coba ubah kata kunci pencarian atau rentang tanggal Anda.</p>
                                    <a href="{{ route('sbp.index') }}" class="btn btn-primary btn-sm mt-1">Reset Semua Filter</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($sbpData->hasPages())
            <div class="d-flex justify-content-start">
                {{ $sbpData->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filterForm');
    const searchInput = form.querySelector('input[name="search"]');
    const dateInput = document.getElementById('dateRangePicker');
    const clearDateBtn = document.getElementById('clearDateFilter');
    const downloadBtn = document.getElementById('downloadExcelBtn');
    let timeout = null;

    // Function to toggle clear button visibility
    const toggleClearButton = () => {
        if (dateInput.value) {
            clearDateBtn.style.display = 'flex';
        } else {
            clearDateBtn.style.display = 'none';
        }
    };

    // Function to toggle download button state
    const toggleDownloadButton = () => {
        if (dateInput.value) {
            downloadBtn.classList.remove('disabled');
            downloadBtn.removeAttribute('aria-disabled');
            downloadBtn.style.pointerEvents = 'auto';
        } else {
            downloadBtn.classList.add('disabled');
            downloadBtn.setAttribute('aria-disabled', 'true');
            downloadBtn.style.pointerEvents = 'none';
        }
    };

    // Debounced form submission for search input
    searchInput.addEventListener('keyup', function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            form.submit();
        }, 500);
    });

    // Initialize Litepicker
    const picker = new Litepicker({
        element: dateInput,
        singleMode: false,
        numberOfMonths: 2,
        format: 'YYYY-MM-DD',
        delimiter: ' - ',
        setup: (picker) => {
            picker.on('selected', (date1, date2) => {
                toggleClearButton();
                toggleDownloadButton();
                form.submit();
            });
        }
    });

    // Clear button functionality
    clearDateBtn.addEventListener('click', () => {
        dateInput.value = '';
        toggleClearButton();
        toggleDownloadButton();
        form.submit();
    });

    // Initial checks on page load
    toggleClearButton();
    toggleDownloadButton();
});
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css"/>
<style>
    .disabled {
        opacity: 0.65;
        cursor: not-allowed;
    }
</style>
@endpush
