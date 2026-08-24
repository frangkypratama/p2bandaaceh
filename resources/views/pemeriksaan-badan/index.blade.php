@extends('layouts.app')

@section('content')
<div class="container-lg">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><strong>Data Pemeriksaan Badan</strong></h5>
            <a href="{{ route('pemeriksaan-badan.create') }}" class="btn btn-primary">
                <i class="cil-plus"></i> Tambah Data
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start">No BA Riksa Badan</th>
                            <th class="text-start">Nama</th>
                            <th class="text-start">Identitas</th>
                            <th class="text-start">Kewarganegaraan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pemeriksaanBadan as $item)
                            <tr>
                                <td class="text-start">{{ $item->no_ba_riksa }}</td>
                                <td class="text-start">{{ $item->nama }}</td>
                                <td class="text-start">{{ $item->jenis_identitas }} / {{ $item->no_identitas }}</td>
                                <td class="text-start">{{ $item->kewarganegaraan }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button type="button" class="btn btn-sm btn-info text-white me-2 preview-btn"
                                            data-coreui-toggle="modal"
                                            data-coreui-target="#previewModal"
                                            data-pdf-url="{{ route('pemeriksaan-badan.cetak', [$item->id, 'is_preview' => true]) }}"
                                            data-pdf-title="Pemeriksaan Badan {{ $item->no_ba_riksa }}"
                                            title="Lihat Pratinjau">
                                            <i class="cil-print"></i>
                                        </button>
                                        <a href="{{ route('pemeriksaan-badan.edit', $item->id) }}" class="btn btn-sm btn-warning text-white me-2" title="Edit Data">
                                            <i class="cil-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger text-white me-2"
                                                data-coreui-toggle="modal"
                                                data-coreui-target="#deleteConfirmationModal"
                                                data-url="{{ route('pemeriksaan-badan.destroy', $item->id) }}"
                                                title="Hapus Data">
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
            @if($pemeriksaanBadan->hasPages())
                <div class="mt-3">
                    {{ $pemeriksaanBadan->links('vendor.pagination.coreui') }}
                </div>
            @endif
        </div>
    </div>
</div>

@include('partials._pdf-viewer')
@endsection
