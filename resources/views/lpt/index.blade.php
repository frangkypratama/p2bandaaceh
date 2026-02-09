@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Data Laporan Pelaksanaan Tugas (LPT)</strong>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#lptModal">
                                <i class="cil-plus me-2"></i>
                                Buat LPT
                            </button>
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
                                            <td>{{ $jenis_lpt_options[$item->jenis_lpt]['name'] ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('lpt.edit', $item->id) }}" class="btn btn-sm btn-warning text-white">
                                                    <i class="cil-pencil"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger" 
                                                        data-coreui-toggle="modal" 
                                                        data-coreui-target="#deleteConfirmationModal"
                                                        data-url="{{ route('lpt.destroy', $item->id) }}">
                                                    <i class="cil-trash"></i>
                                                </button>
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

    <!-- Modal -->
    <div class="modal fade" id="lptModal" tabindex="-1" aria-labelledby="lptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lptModalLabel">Pilih Jenis LPT</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        @foreach($jenis_lpt_options as $key => $options)
                            <a href="{{ route('lpt.create', ['jenis' => $key]) }}" class="list-group-item list-group-item-action">
                                <i class="{{ $options['icon'] }} me-2"></i>{{ $options['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
