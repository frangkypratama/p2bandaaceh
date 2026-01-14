@extends('layouts.app')

@section('content')
<div class="container-lg">
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">Data Surat Bukti Penindakan (SBP)</h4>
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
                                    <div>{{ \Carbon\Carbon::parse($sbp->tanggal_sbp)->translatedFormat('d F Y') }}</div>
                                </td>
                                <td>
                                    <div>{{ $sbp->nama_pelaku }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-info text-white me-2" data-coreui-toggle="modal" data-coreui-target="#lihatModal{{ $sbp->id }}" title="Lihat Detail">
                                            <i class="cil-search"></i>
                                        </button>
                                        <a href="{{ route('sbp.edit', $sbp->id) }}" class="btn btn-sm btn-primary me-2" title="Edit Data">
                                            <i class="cil-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-coreui-toggle="modal" data-coreui-target="#hapusModal{{ $sbp->id }}" title="Hapus Data">
                                            <i class="cil-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Lihat -->
                            <div class="modal fade" id="lihatModal{{ $sbp->id }}" tabindex="-1" aria-labelledby="lihatModalLabel{{ $sbp->id }}" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="lihatModalLabel{{ $sbp->id }}">Detail SBP</h5>
                                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <p><strong>Nomor SBP:</strong> {{ $sbp->nomor_sbp }}</p>
                                    <p><strong>Tanggal SBP:</strong> {{ \Carbon\Carbon::parse($sbp->tanggal_sbp)->translatedFormat('d F Y') }}</p>
                                    <p><strong>Nama Pelaku:</strong> {{ $sbp->nama_pelaku }}</p>
                                    <p><strong>Alamat Pelaku:</strong> {{ $sbp->alamat_pelaku }}</p>
                                    <p><strong>Jabatan:</strong> {{ $sbp->jabatan }}</p>
                                    <p><strong>Nomor Register:</strong> {{ $sbp->nomor_register }}</p>
                                    <p><strong>Barang Bukti:</strong> {{ $sbp->barang_bukti }}</p>
                                    <p><strong>Jenis Pelanggaran:</strong> {{ $sbp->jenis_pelanggaran }}</p>
                                    <p><strong>Tempat Pelanggaran:</strong> {{ $sbp->tempat_pelanggaran }}</p>
                                    <p><strong>Tanggal Pelanggaran:</strong> {{ \Carbon\Carbon::parse($sbp->tanggal_pelanggaran)->translatedFormat('d F Y') }}</p>
                                    <p><strong>Jam Pelanggaran:</strong> {{ $sbp->jam_pelanggaran }}</p>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Tutup</button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Modal Hapus -->
                            <div class="modal fade" id="hapusModal{{ $sbp->id }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $sbp->id }}" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="hapusModalLabel{{ $sbp->id }}">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus Data SBP dengan nomor <strong>{{ $sbp->nomor_sbp }}</strong>?
                                  </div>
                                  <div class="modal-footer">
                                    <form action="{{ route('sbp.destroy', $sbp->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
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
