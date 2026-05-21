@extends('layouts.app')

@section('title', 'Data SBP')

@section('content')
<div class="container-lg">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><strong>Data Surat Bukti Penindakan (SBP)</strong></h5>
            <a href="{{ route('sbp.create') }}" class="btn btn-primary">
                <i class="cil-plus"></i>
                Tambah Data
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nomor SBP</th>
                            <th>Tanggal SBP</th>
                            <th>Pelaku</th>
                            <th>Identitas</th>
                            <th>Jenis Barang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sbpData as $sbp)
                            <tr>
                                <td>{{ $sbp->nomor_sbp }}</td>
                                <td>{{ \Carbon\Carbon::parse($sbp->tanggal_sbp)->translatedFormat('d F Y') }}</td>
                                <td>{{ $sbp->nama_pelaku }}</td>
                                <td>{{ $sbp->jenis_identitas }} / {{ $sbp->nomor_identitas }}</td>
                                <td>{{ $sbp->jenis_barang }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('sbp.cetak.preview', $sbp->id) }}" class="btn btn-sm btn-info text-white me-2" title="Lihat Pratinjau">
                                            <i class="cil-print"></i>
                                        </a>
                                        <a href="{{ route('sbp.edit', $sbp->id) }}" class="btn btn-sm btn-warning text-white me-2" title="Edit Data">
                                            <i class="cil-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger text-white me-2"
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
                                <td colspan="6" class="text-center py-4">Belum ada data SBP.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-start">
                {{ $sbpData->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
