@extends('layouts.app')

@section('title', 'Data LPP')

@section('content')
<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><strong>Data Lembar Penerimaan Perkara (LPP)</strong></h5>
                    <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#lpPickerModal">
                        <i class="cil-plus"></i>
                        Tambah Data
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nomor LPP</th>
                                    <th scope="col">Tanggal LPP</th>
                                    <th scope="col">Nomor LP</th>
                                    <th scope="col">Nomor SBP</th>
                                    <th scope="col">Nama Pelaku</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lpp as $item)
                                    @php $sbp = optional(optional($item->lp)->lphp)->sbp; @endphp
                                    <tr>
                                        <td>{{ $item->nomor_lpp }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_lpp)->isoFormat('D MMMM Y') }}</td>
                                        <td>
                                            <span class="badge bg-info text-white">{{ optional($item->lp)->nomor_lp ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success text-white">{{ optional($sbp)->nomor_sbp ?? '-' }}</span>
                                        </td>
                                        <td>{{ optional($sbp)->nama_pelaku ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-info text-white preview-btn me-2"
                                                        data-pdf-url="{{ route('lpp.preview', $item->id) }}"
                                                        data-pdf-title="{{ $item->nomor_lpp }}" title="Cetak LPP">
                                                    <i class="cil-print"></i>
                                                </button>

                                                <a href="{{ route('lpp.edit', $item->id) }}" class="btn btn-sm btn-warning text-white me-2" title="Edit Data">
                                                    <i class="cil-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger text-white me-2"
                                                        data-coreui-toggle="modal"
                                                        data-coreui-target="#deleteConfirmationModal"
                                                        data-url="{{ route('lpp.destroy', $item->id) }}"
                                                        title="Hapus Data">
                                                    <i class="cil-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data untuk ditampilkan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-start">
                        {{ $lpp->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Pilih LP (di luar form apa pun - hanya berfungsi sebagai navigasi ke halaman create) --}}
<div class="modal fade" id="lpPickerModal" tabindex="-1" aria-labelledby="lpPickerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lpPickerModalLabel">Pilih LP untuk Dibuat LPP</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="lpPickerModalBody">
                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                    <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials._pdf-viewer')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var lpPickerModalEl = document.getElementById('lpPickerModal');
    var lpPickerModalBody = document.getElementById('lpPickerModalBody');
    var loaded = false;

    function loadLpPicker(url) {
        lpPickerModalBody.innerHTML = '<div class="d-flex justify-content-center align-items-center" style="height: 200px;"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (response) { return response.text(); })
            .then(function (html) { lpPickerModalBody.innerHTML = html; })
            .catch(function () {
                lpPickerModalBody.innerHTML = '<p class="text-center text-danger">Gagal memuat data LP. Silakan coba lagi.</p>';
            });
    }

    lpPickerModalEl.addEventListener('show.coreui.modal', function () {
        if (!loaded) {
            loaded = true;
            loadLpPicker('{{ route('lpp.pilih-lp') }}');
        }
    });

    lpPickerModalBody.addEventListener('click', function (e) {
        var pageLink = e.target.closest('.pagination a');
        if (pageLink) {
            e.preventDefault();
            loadLpPicker(pageLink.getAttribute('href'));
        }
    });
});
</script>
@endpush
