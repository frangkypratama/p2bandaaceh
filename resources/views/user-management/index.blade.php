@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="container-lg">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><strong>User Management</strong></h5>
            <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#tambahUserModal">
                <i class="cil-plus"></i> Tambah User
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%;">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">NIP</th>
                            <th scope="col">Petugas Terkait</th>
                            <th scope="col" class="text-center" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($userData as $key => $user)
                            <tr>
                                <th scope="row" class="text-center">{{ $userData->firstItem() + $key }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->nip }}</td>
                                <td>
                                    @if ($user->petugas)
                                        <span class="badge bg-success">{{ $user->petugas->nama }}</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak ditautkan</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-warning text-white" data-coreui-toggle="modal" data-coreui-target="#editUserModal-{{ $user->id }}" title="Edit User">
                                        <i class="cil-pencil"></i>
                                    </button>

                                    <form action="{{ route('user-management.reset-password', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Reset password {{ $user->name }} kembali ke NIP?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Reset Password ke NIP">
                                            <i class="cil-lock-locked"></i>
                                        </button>
                                    </form>

                                    @if ($user->id !== auth()->id())
                                        <button type="button" class="btn btn-sm btn-danger text-white"
                                                data-coreui-toggle="modal"
                                                data-coreui-target="#deleteConfirmationModal"
                                                data-url="{{ route('user-management.destroy', $user->id) }}"
                                                title="Hapus User">
                                            <i class="cil-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal Edit User -->
                            <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel-{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editUserModalLabel-{{ $user->id }}">Edit User</h5>
                                            <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('user-management.update', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="name-{{ $user->id }}" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="name-{{ $user->id }}" name="name" value="{{ old('name', $user->name) }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nip-{{ $user->id }}" class="form-label">NIP (username)</label>
                                                    <input type="text" class="form-control" id="nip-{{ $user->id }}" name="nip" value="{{ old('nip', $user->nip) }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="petugas_id-{{ $user->id }}" class="form-label">Tautkan ke Petugas</label>
                                                    @php
                                                        $editPetugasOptions = $petugasOptions;
                                                        if ($user->petugas) {
                                                            $editPetugasOptions = $editPetugasOptions->push($user->petugas)->sortBy('nama');
                                                        }
                                                    @endphp
                                                    <select class="form-select" id="petugas_id-{{ $user->id }}" name="petugas_id">
                                                        <option value="">- Tidak ditautkan -</option>
                                                        @foreach ($editPetugasOptions as $petugas)
                                                            <option value="{{ $petugas->id }}" {{ (old('petugas_id', $user->petugas_id) == $petugas->id) ? 'selected' : '' }}>
                                                                {{ $petugas->nama }} ({{ $petugas->nip }})
                                                            </option>
                                                        @endforeach
                                                    </select>
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
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">Belum ada akun user. Silakan tambahkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $userData->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user-management.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP (username)</label>
                        <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip') }}" required>
                        <div class="form-text">NIP tanpa spasi akan dipakai sebagai username sekaligus password awal.</div>
                    </div>
                    <div class="mb-3">
                        <label for="petugas_id_tambah" class="form-label">Tautkan ke Petugas (opsional)</label>
                        <select class="form-select" id="petugas_id_tambah" name="petugas_id">
                            <option value="">- Tidak ditautkan -</option>
                            @foreach ($petugasOptions as $petugas)
                                <option value="{{ $petugas->id }}" {{ old('petugas_id') == $petugas->id ? 'selected' : '' }}>
                                    {{ $petugas->nama }} ({{ $petugas->nip }})
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Hanya petugas yang belum punya akun yang muncul di sini.</div>
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
