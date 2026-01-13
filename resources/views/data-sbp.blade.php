@extends('layouts.app')

@section('content')
<div class="container-lg">
    <div class="card mb-4">
        <div class="card-header">
            <h1 class="mb-0">Data Surat Bukti Pelanggaran (SBP)</h1>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Nomor SBP</th>
                            <th>Tanggal SBP</th>
                            <th>Pelaku</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sbpData as $sbp)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $sbp->nomor_sbp }}</div>
                                </td>
                                <td>
                                    <div>{{ \Carbon\Carbon::parse($sbp->tanggal_sbp)->format('d F Y') }}</div>
                                </td>
                                <td>
                                    <div>{{ $sbp->nama_pelaku }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-info text-white me-2" title="Lihat Detail" disabled>
                                            <i class="cil-search"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary me-2" title="Edit Data" disabled>
                                            <i class="cil-pencil"></i>
                                        </button>
                                        <form action="{{ route('sbp.destroy', $sbp->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data">
                                                <i class="cil-trash"></i>
                                            </button>
                                        </form>
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
