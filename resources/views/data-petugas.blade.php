@extends('layouts.app')

@section('title', 'Data Petugas')

@section('content')
<div class="container-lg">
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">Data Petugas</h4>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#tambahPetugasModal">
                    <i class="cil-plus"></i> Tambah Petugas
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Petugas</th>
                            <th>NIP</th>
                            <th>Pangkat/Golongan</th>
                            <th>Jabatan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($petugasData as $petugas)
                            <tr>
                                <td>{{ $petugas->nama }}</td>
                                <td>{{ $petugas->nip }}</td>
                                <td>{{ $petugas->pangkat ?? '-' }} / {{ $petugas->golongan ?? '-' }}</td>
                                <td>{{ $petugas->jabatan ?? '-' }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary" data-coreui-toggle="modal" data-coreui-target="#editModal-{{ $petugas->id }}" title="Edit Data">
                                        <i class="cil-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            data-coreui-toggle="modal" 
                                            data-coreui-target="#deleteConfirmationModal"
                                            data-url="{{ route('petugas.destroy', $petugas->id) }}"
                                            title="Hapus Data">
                                        <i class="cil-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal-{{ $petugas->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $petugas->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel-{{ $petugas->id }}">Edit Petugas</h5>
                                            <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('petugas.update', $petugas->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="nama-{{ $petugas->id }}" class="form-label">Nama Petugas</label>
                                                    <input type="text" class="form-control" id="nama-{{ $petugas->id }}" name="nama" value="{{ old('nama', $petugas->nama) }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nip-{{ $petugas->id }}" class="form-label">NIP</label>
                                                    <input type="text" class="form-control" id="nip-{{ $petugas->id }}" name="nip" value="{{ old('nip', $petugas->nip) }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pangkat_golongan_id-{{ $petugas->id }}" class="form-label">Pangkat / Golongan</label>
                                                    <select class="form-select" id="pangkat_golongan_id-{{ $petugas->id }}" name="pangkat_golongan_id">
                                                        <option value="">- Kosongkan -</option>
                                                        @foreach($pangkatGolonganData as $item)
                                                            <option value="{{ $item->id }}" {{ ($petugas->pangkat == $item->pangkat && $petugas->golongan == $item->golongan) ? 'selected' : '' }}>
                                                                {{ $item->pangkat }} - {{ $item->golongan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jabatan-{{ $petugas->id }}" class="form-label">Jabatan</label>
                                                    <input type="text" class="form-control" id="jabatan-{{ $petugas->id }}" name="jabatan" value="{{ old('jabatan', $petugas->jabatan) }}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Belum ada data petugas. Silakan tambahkan.</td>
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

<!-- Modal Tambah Petugas -->
<div class="modal fade" id="tambahPetugasModal" tabindex="-1" aria-labelledby="tambahPetugasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPetugasModalLabel">Tambah Petugas Baru</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('petugas.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Petugas</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="pangkat_golongan_id" class="form-label">Pangkat / Golongan</label>
                        <select class="form-select" id="pangkat_golongan_id" name="pangkat_golongan_id">
                            <option selected disabled value="">Pilih Pangkat / Golongan...</option>
                             @foreach($pangkatGolonganData as $item)
                                <option value="{{ $item->id }}" {{ old('pangkat_golongan_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->pangkat }} - {{ $item->golongan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ old('jabatan') }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
