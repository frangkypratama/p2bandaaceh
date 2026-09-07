@extends('layouts.app')

@section('title', 'Data LPHP')

@section('content')
<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><strong>Data Lembar Penentuan Hasil Penindakan (LPHP)</strong></h5>
                    <a href="{{ route('sbp.index') }}" class="btn btn-primary">
                        <i class="cil-plus"></i>
                        Buat dari Data SBP
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nomor LPHP</th>
                                    <th scope="col">Tanggal LPHP</th>
                                    <th scope="col">Nomor SBP</th>
                                    <th scope="col">Nama Pelaku</th>
                                    <th scope="col">Dugaan Pelanggaran</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lphp as $item)
                                    <tr>
                                        <td>{{ $item->nomor_lphp }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_lphp)->isoFormat('D MMMM Y') }}</td>
                                        <td>
                                            <span class="badge bg-info text-white">{{ optional($item->sbp)->nomor_sbp ?? 'N/A' }}</span>
                                        </td>
                                        <td>{{ optional($item->sbp)->nama_pelaku ?? '-' }}</td>
                                        <td>{{ $item->dugaan_pelanggaran }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-info text-white preview-btn me-2"
                                                        data-pdf-url="{{ route('lphp.preview', $item->id) }}"
                                                        data-pdf-title="{{ $item->nomor_lphp }}" title="Cetak LPHP">
                                                    <i class="cil-print"></i>
                                                </button>

                                                @if($item->lp)
                                                    <button type="button" class="btn btn-sm btn-info text-white preview-btn me-2"
                                                            data-pdf-url="{{ route('lp.preview', $item->lp->id) }}"
                                                            data-pdf-title="{{ $item->lp->nomor_lp }}" title="Cetak Laporan Pelanggaran">
                                                        <i class="cil-description"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('lp.create', ['lphp_id' => $item->id]) }}" class="btn btn-sm btn-success text-white me-2" title="Buat Laporan Pelanggaran">
                                                        <i class="cil-plus"></i>
                                                    </a>
                                                @endif

                                                <a href="{{ route('lphp.edit', $item->id) }}" class="btn btn-sm btn-warning text-white me-2" title="Edit Data">
                                                    <i class="cil-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger text-white me-2"
                                                        data-coreui-toggle="modal"
                                                        data-coreui-target="#deleteConfirmationModal"
                                                        data-url="{{ route('lphp.destroy', $item->id) }}"
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
                        {{ $lphp->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials._pdf-viewer')
@endsection
