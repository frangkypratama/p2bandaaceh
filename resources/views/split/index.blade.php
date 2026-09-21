@extends('layouts.app')

@section('title', 'Data SPLIT')

@section('content')
<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><strong>Data Surat Perintah Penelitian (SPLIT)</strong></h5>
                    <a href="{{ route('lpf.index') }}" class="btn btn-primary">
                        <i class="cil-plus"></i>
                        Tambah Data
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nomor SPLIT</th>
                                    <th scope="col">Tanggal SPLIT</th>
                                    <th scope="col">Nomor LPF</th>
                                    <th scope="col">Nomor SBP</th>
                                    <th scope="col">Nama Pelaku</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($split as $item)
                                    @php $sbp = optional(optional(optional(optional($item->lpf)->lpp)->lp)->lphp)->sbp; @endphp
                                    <tr>
                                        <td>{{ $item->nomor_split }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_split)->isoFormat('D MMMM Y') }}</td>
                                        <td>
                                            <span class="badge bg-info text-white">{{ optional($item->lpf)->nomor_lpf ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success text-white">{{ optional($sbp)->nomor_sbp ?? '-' }}</span>
                                        </td>
                                        <td>{{ optional($sbp)->nama_pelaku ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-info text-white preview-btn me-2"
                                                        data-pdf-url="{{ route('split.preview', $item->id) }}"
                                                        data-pdf-title="{{ $item->nomor_split }}" title="Cetak SPLIT">
                                                    <i class="cil-print"></i>
                                                </button>

                                                @if($item->lhp)
                                                    <button type="button" class="btn btn-sm btn-info text-white preview-btn me-2"
                                                            data-pdf-url="{{ route('lhp.preview', $item->lhp->id) }}"
                                                            data-pdf-title="{{ $item->lhp->nomor_lhp }}" title="Cetak LHP">
                                                        <i class="cil-description"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('lhp.create', ['split_id' => $item->id]) }}" class="btn btn-sm btn-success text-white me-2" title="Buat LHP">
                                                        <i class="cil-plus"></i>
                                                    </a>
                                                @endif

                                                <a href="{{ route('split.edit', $item->id) }}" class="btn btn-sm btn-warning text-white me-2" title="Edit Data">
                                                    <i class="cil-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger text-white me-2"
                                                        data-coreui-toggle="modal"
                                                        data-coreui-target="#deleteConfirmationModal"
                                                        data-url="{{ route('split.destroy', $item->id) }}"
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
                        {{ $split->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials._pdf-viewer')
@endsection
