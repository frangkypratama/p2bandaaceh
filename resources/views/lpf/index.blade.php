@extends('layouts.app')

@section('title', 'Data LPF')

@section('content')
<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><strong>Data Lembar Penelitian Formal (LPF)</strong></h5>
                    <a href="{{ route('lpp.index') }}" class="btn btn-primary">
                        <i class="cil-plus"></i>
                        Tambah Data
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nomor LPF</th>
                                    <th scope="col">Tanggal LPF</th>
                                    <th scope="col">Nomor LPP</th>
                                    <th scope="col">Nomor SBP</th>
                                    <th scope="col">Nama Pelaku</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lpf as $item)
                                    @php $sbp = optional(optional(optional($item->lpp)->lp)->lphp)->sbp; @endphp
                                    <tr>
                                        <td>{{ $item->nomor_lpf }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_lpf)->isoFormat('D MMMM Y') }}</td>
                                        <td>
                                            <span class="badge bg-info text-white">{{ optional($item->lpp)->nomor_lpp ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success text-white">{{ optional($sbp)->nomor_sbp ?? '-' }}</span>
                                        </td>
                                        <td>{{ optional($sbp)->nama_pelaku ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-info text-white preview-btn me-2"
                                                        data-pdf-url="{{ route('lpf.preview', $item->id) }}"
                                                        data-pdf-title="{{ $item->nomor_lpf }}" title="Cetak LPF">
                                                    <i class="cil-print"></i>
                                                </button>

                                                @if($item->split)
                                                    <button type="button" class="btn btn-sm btn-info text-white preview-btn me-2"
                                                            data-pdf-url="{{ route('split.preview', $item->split->id) }}"
                                                            data-pdf-title="{{ $item->split->nomor_split }}" title="Cetak SPLIT">
                                                        <i class="cil-description"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('split.create', ['lpf_id' => $item->id]) }}" class="btn btn-sm btn-success text-white me-2" title="Buat SPLIT">
                                                        <i class="cil-plus"></i>
                                                    </a>
                                                @endif

                                                <a href="{{ route('lpf.edit', $item->id) }}" class="btn btn-sm btn-warning text-white me-2" title="Edit Data">
                                                    <i class="cil-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger text-white me-2"
                                                        data-coreui-toggle="modal"
                                                        data-coreui-target="#deleteConfirmationModal"
                                                        data-url="{{ route('lpf.destroy', $item->id) }}"
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
                        {{ $lpf->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials._pdf-viewer')
@endsection
