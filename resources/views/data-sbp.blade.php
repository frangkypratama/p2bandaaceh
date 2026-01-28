@extends('layouts.app')

@section('title', 'Data SBP')

@section('content')
<div class="container-lg">
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">Data Surat Bukti Penindakan (SBP)</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Nomor SBP</th>
                            <th>Tanggal SBP</th>
                            <th>Pelaku</th>
                            <th>Identitas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sbpData as $sbp)
                            <tr>
                                <td>
                                    <div>{{ $sbp->nomor_sbp }}</div>
                                </td>
                                <td>
                                    <div>{{ \Carbon\Carbon::parse($sbp->tanggal_sbp)->translatedFormat('d F Y') }}</div>
                                </td>
                                <td>
                                    <div>{{ $sbp->nama_pelaku }}</div>
                                </td>
                                <td>
                                    <div>{{ $sbp->jenis_identitas }} / {{ $sbp->nomor_identitas }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('sbp.cetak.preview', $sbp->id) }}" class="btn btn-sm btn-info text-white me-2" title="Lihat Pratinjau">
                                            <i class="cil-search"></i>
                                        </a>
                                        <a href="{{ route('sbp.edit', $sbp->id) }}" class="btn btn-sm btn-primary me-2" title="Edit Data">
                                            <i class="cil-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
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
                                <td colspan="4" class="text-center py-4">Belum ada data SBP.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $sbpData->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
