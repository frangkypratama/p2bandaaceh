@extends('layouts.app')

@section('content')
<div class="container-lg">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><strong>Data Pencacahan</strong></h5>
            <a href="{{ route('pencacahan.create') }}" class="btn btn-primary">
                <i class="cil-plus"></i> Tambah Data
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start">Nomor BA Cacah</th>
                            <th class="text-start">Tanggal</th>
                            <th class="text-start">Nomor Surat Tugas</th>
                            <th class="text-start">Giat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pencacahan as $item)
                            <tr class="row-clickable" data-href="{{ route('pencacahan.show', $item->id) }}" style="cursor: pointer;">
                                <td class="text-start">{{ $item->no_ba_cacah }}</td>
                                <td class="text-start">{{ \Carbon\Carbon::parse($item->tanggal_ba_cacah)->translatedFormat('d F Y') }}</td>
                                <td class="text-start">{{ $item->no_surat_tugas_pencacahan ?? '-' }}</td>
                                <td class="text-start">{{ $item->giat ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2" role="group" aria-label="Aksi">
                                        <button type="button" class="btn btn-info btn-sm text-white preview-btn"
                                                data-pdf-url="{{ route('pencacahan.cetak', $item->id) }}"
                                                data-pdf-title="Berita Acara Pencacahan {{ $item->no_ba_cacah }}">
                                            <i class="cil-print"></i>
                                        </button>
                                        <a href="{{ route('pencacahan.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="cil-pencil"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                                data-coreui-toggle="modal"
                                                data-coreui-target="#deleteConfirmationModal"
                                                data-url="{{ route('pencacahan.destroy', $item->id) }}">
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
            @if($pencacahan->hasPages())
                <div class="mt-3">
                    {{ $pencacahan->links('vendor.pagination.coreui') }}
                </div>
            @endif
        </div>
    </div>
</div>

@include('partials._pdf-viewer')

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('tr.row-clickable').forEach(function (row) {
        row.addEventListener('click', function (e) {
            if (e.target.closest('button, a')) return;
            window.location.href = row.dataset.href;
        });
    });
});
</script>
@endpush
