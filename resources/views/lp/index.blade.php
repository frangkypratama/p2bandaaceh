@extends('layouts.app')

@section('title', 'Data Laporan Pelanggaran')

@section('content')
<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><strong>Data Laporan Pelanggaran (LP)</strong></h5>
                    <a href="{{ route('lphp.index') }}" class="btn btn-primary">
                        <i class="cil-plus"></i>
                        Tambah Data
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nomor LP</th>
                                    <th scope="col">Tanggal LP</th>
                                    <th scope="col">Nomor LPHP</th>
                                    <th scope="col">Nomor SBP</th>
                                    <th scope="col">Nama Pelaku</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lp as $item)
                                    <tr>
                                        <td>{{ $item->nomor_lp }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_lp)->isoFormat('D MMMM Y') }}</td>
                                        <td>
                                            <span class="badge bg-info text-white">{{ optional($item->lphp)->nomor_lphp ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success text-white">{{ optional(optional($item->lphp)->sbp)->nomor_sbp ?? '-' }}</span>
                                        </td>
                                        <td>{{ optional(optional($item->lphp)->sbp)->nama_pelaku ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-info text-white preview-btn me-2"
                                                        data-pdf-url="{{ route('lp.preview', $item->id) }}"
                                                        data-pdf-title="{{ $item->nomor_lp }}" title="Cetak LP">
                                                    <i class="cil-print"></i>
                                                </button>
                                                <a href="{{ route('lp.edit', $item->id) }}" class="btn btn-sm btn-warning text-white me-2" title="Edit Data">
                                                    <i class="cil-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger text-white me-2"
                                                        data-coreui-toggle="modal"
                                                        data-coreui-target="#deleteConfirmationModal"
                                                        data-url="{{ route('lp.destroy', $item->id) }}"
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
                        {{ $lp->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials._pdf-viewer')
@endsection
