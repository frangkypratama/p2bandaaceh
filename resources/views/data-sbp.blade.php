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
                                        <button type="button" class="btn btn-sm btn-primary me-2" data-coreui-toggle="modal" data-coreui-target="#editModal{{ $sbp->id }}" title="Edit Data">
                                            <i class="cil-pencil"></i>
                                        </button>
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

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal{{ $sbp->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $sbp->id }}" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $sbp->id }}">Edit SBP</h5>
                                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form action="{{ route('sbp.update', $sbp->id) }}" method="POST">
                                      @csrf
                                      @method('PUT')
                                      <div class="modal-body">
                                          <div class="mb-3">
                                              <label for="nomor_sbp" class="form-label">Nomor SBP</label>
                                              <input type="text" class="form-control" id="nomor_sbp" name="nomor_sbp" value="{{ $sbp->nomor_sbp }}" required>
                                          </div>
                                          <div class="mb-3">
                                              <label for="tanggal_sbp" class="form-label">Tanggal SBP</label>
                                              <input type="date" class="form-control" id="tanggal_sbp" name="tanggal_sbp" value="{{ $sbp->tanggal_sbp }}" required>
                                          </div>
                                          <div class="mb-3">
                                              <label for="nama_pelaku" class="form-label">Nama Pelaku</label>
                                              <input type="text" class="form-control" id="nama_pelaku" name="nama_pelaku" value="{{ $sbp->nama_pelaku }}" required>
                                          </div>
                                          <div class="mb-3">
                                            <label for="alamat_pelaku" class="form-label">Alamat Pelaku</label>
                                            <textarea class="form-control" id="alamat_pelaku" name="alamat_pelaku" rows="3" required>{{ $sbp->alamat_pelaku }}</textarea>
                                          </div>
                                          <div class="mb-3">
                                              <label for="jabatan" class="form-label">Jabatan</label>
                                              <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $sbp->jabatan }}" required>
                                          </div>
                                          <div class="mb-3">
                                              <label for="nomor_register" class="form-label">Nomor Register</label>
                                              <input type="text" class="form-control" id="nomor_register" name="nomor_register" value="{{ $sbp->nomor_register }}" required>
                                          </div>
                                          <div class="mb-3">
                                              <label for="barang_bukti" class="form-label">Barang Bukti</label>
                                              <input type="text" class="form-control" id="barang_bukti" name="barang_bukti" value="{{ $sbp->barang_bukti }}" required>
                                          </div>
                                          <div class="mb-3">
                                              <label for="jenis_pelanggaran" class="form-label">Jenis Pelanggaran</label>
                                              <input type="text" class="form-control" id="jenis_pelanggaran" name="jenis_pelanggaran" value="{{ $sbp->jenis_pelanggaran }}" required>
                                          </div>
                                          <div class="mb-3">
                                              <label for="tempat_pelanggaran" class="form-label">Tempat Pelanggaran</label>
                                              <input type="text" class="form-control" id="tempat_pelanggaran" name="tempat_pelanggaran" value="{{ $sbp->tempat_pelanggaran }}" required>
                                          </div>
                                          <div class="mb-3">
                                              <label for="tanggal_pelanggaran" class="form-label">Tanggal Pelanggaran</label>
                                              <input type="date" class="form-control" id="tanggal_pelanggaran" name="tanggal_pelanggaran" value="{{ $sbp->tanggal_pelanggaran }}" required>
                                          </div>
                                          <div class="mb-3">
                                              <label for="jam_pelanggaran" class="form-label">Jam Pelanggaran</label>
                                              <input type="time" class="form-control" id="jam_pelanggaran" name="jam_pelanggaran" value="{{ $sbp->jam_pelanggaran }}" required>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Batal</button>
                                          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                      </div>
                                  </form>
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
