@extends('layouts.app')

@section('content')

{{-- Styles for PDF Viewer --}}
<style>
    #cetakModal .pdf-viewer-container {
        background-color: #525252;
        overflow-y: auto;
        position: relative;
        height: 70vh;
    }
    #cetakModal .pdf-page-wrapper {
        display: flex;
        justify-content: center;
        padding: 10px 0;
    }
    #cetakModal .pdf-page-wrapper canvas {
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        background: white;
    }
    #cetakModal .pdf-loading {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 10;
        color: white;
    }
    #cetakModal .pdf-toolbar {
        background-color: #f8f9fa;
        padding: 8px 12px;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
</style>

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
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No BA Cacah</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pencacahan as $item)
                            <tr>
                                <td class="text-center">{{ $item->no_ba_cacah }}</td>
                                <td class="text-center">{{ $item->tanggal_ba_cacah }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2" role="group" aria-label="Aksi">
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
                                <td colspan="3" class="text-center">Tidak ada data.</td>
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
@endsection