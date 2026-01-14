@extends('layouts.app')

@section('content')
<div class="container-lg">
    <div class="card mb-4">
        <div class="card-header">
            <h1 class="mb-0">Data Petugas</h1>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#tambahModal">
                    Tambah Petugas
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($petugasData as $petugas)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $petugas->nama }}</div>
                                </td>
                                <td>
                                    <div>{{ $petugas->nip }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-primary me-2" data-coreui-toggle="modal" data-coreui-target="#editModal{{ $petugas->id }}" title="Edit Data">
                                            <i class="cil-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-coreui-toggle="modal" data-coreui-target="#hapusModal{{ $petugas->id }}" title="Hapus Data">
                                            <i class="cil-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal{{ $petugas->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $petugas->id }}" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $petugas->id }}">Edit Petugas</h5>
                                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form action="{{ route('petugas.update', $petugas->id) }}" method="POST">
                                      @csrf
                                      @method('PUT')
                                      <div class="modal-body">
                                          <div class="mb-3">
                                              <label for="nama{{ $petugas->id }}" class="form-label">Nama</label>
                                              <input type="text" class="form-control" id="nama{{ $petugas->id }}" name="nama" value="{{ $petugas->nama }}" required>
                                          </div>
                                          <div class="mb-3">
                                              <label for="nip{{ $petugas->id }}" class="form-label">NIP</label>
                                              <input type="text" class="form-control" id="nip{{ $petugas->id }}" name="nip" value="{{ $petugas->nip }}" required>
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
                            <div class="modal fade" id="hapusModal{{ $petugas->id }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $petugas->id }}" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="hapusModalLabel{{ $petugas->id }}">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus data petugas dengan nama <strong>{{ $petugas->nama }}</strong>?
                                  </div>
                                  <div class="modal-footer">
                                    <form action="{{ route('petugas.destroy', $petugas->id) }}" method="POST">
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
                                <td colspan="3" class="text-center py-4">Belum ada data petugas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $petugasData->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahModalLabel">Tambah Petugas</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('petugas.store') }}" method="POST">
          @csrf
          <div class="modal-body">
              <div class="mb-3">
                  <label for="nama_tambah" class="form-label">Nama</label>
                  <input type="text" class="form-control" id="nama_tambah" name="nama" required>
              </div>
              <div class="mb-3">
                  <label for="nip_tambah" class="form-label">NIP</label>
                  <input type="text" class="form-control" id="nip_tambah" name="nip" required>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection
