@extends('layouts.app')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dasbor</a></li>
        <li class="breadcrumb-item active">Data LPT</li>
    </ol>
@endsection

@section('content')
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Data Laporan Pelaksanaan Tugas (LPT)</strong>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                <i class="cil-check-circle me-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <a href="{{ route('lpt.create') }}" class="btn btn-primary">
                                <i class="cil-plus me-2"></i>
                                Tambah LPT
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Nomor LPT</th>
                                        <th scope="col">Tanggal LPT</th>
                                        <th scope="col">Nomor SBP</th>
                                        <th scope="col">Jenis LPT</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lpt as $item)
                                        <tr>
                                            <td>{{ $item->nomor_lpt }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_lpt)->isoFormat('D MMMM Y') }}</td>
                                            <td>
                                                <span class="badge bg-info text-white">{{ $item->sbp?->nomor_sbp ?? 'N/A' }}</span>
                                            </td>
                                            <td>{{ $item->jenis_lpt }}</td>
                                            <td>
                                                <a href="{{ route('lpt.edit', $item->id) }}" class="btn btn-sm btn-warning text-white">
                                                    <i class="cil-pencil"></i>
                                                </a>
                                                <form action="{{ route('lpt.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="cil-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data untuk ditampilkan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $lpt->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
