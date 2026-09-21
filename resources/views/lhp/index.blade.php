@extends('layouts.app')

@section('title', 'Data LHP')

@section('content')
<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><strong>Data Lembar Hasil Penelitian (LHP)</strong></h5>
                    <a href="{{ route('split.index') }}" class="btn btn-primary">
                        <i class="cil-plus"></i>
                        Tambah Data
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nomor LHP</th>
                                    <th scope="col">Tanggal LHP</th>
                                    <th scope="col">Nomor LP</th>
                                    <th scope="col">Nomor SBP</th>
                                    <th scope="col">Nama Pelaku</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lhp as $item)
                                    @php
                                        $lp = optional(optional($item->split)->lpf)->lpp?->lp;
                                        $sbp = optional($lp)->lphp?->sbp;
                                    @endphp
                                    <tr>
                                        <td>{{ $item->nomor_lhp }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_lhp)->isoFormat('D MMMM Y') }}</td>
                                        <td>
                                            <span class="badge bg-info text-white">{{ optional($lp)->nomor_lp ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success text-white">{{ optional($sbp)->nomor_sbp ?? '-' }}</span>
                                        </td>
                                        <td>{{ optional($sbp)->nama_pelaku ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-info text-white preview-btn me-2"
                                                        data-pdf-url="{{ route('lhp.preview', $item->id) }}"
                                                        data-pdf-title="{{ $item->nomor_lhp }}" title="Cetak LHP">
                                                    <i class="cil-print"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-secondary text-white preview-btn me-2"
                                                        data-pdf-url="{{ route('lhp.preview-berkas', $item->id) }}"
                                                        data-pdf-title="Berkas Penyidikan - {{ optional($lp)->nomor_lp }}" title="Cetak Lengkap Berkas Penyidikan (LP+LPP+SPLIT+LPF+LHP)">
                                                    <i class="cil-library"></i>
                                                </button>

                                                <a href="{{ route('lhp.edit', $item->id) }}" class="btn btn-sm btn-warning text-white me-2" title="Edit Data">
                                                    <i class="cil-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger text-white me-2"
                                                        data-coreui-toggle="modal"
                                                        data-coreui-target="#deleteConfirmationModal"
                                                        data-url="{{ route('lhp.destroy', $item->id) }}"
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
                        {{ $lhp->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials._pdf-viewer')
@endsection
