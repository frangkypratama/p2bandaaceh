@extends('layouts.app')

@section('title', 'Role Management')

@section('content')
<div class="container-lg">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><strong>Role Management</strong></h5>
            <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#tambahRoleModal">
                <i class="cil-plus"></i> Tambah Role
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%;">No</th>
                            <th scope="col">Nama Role</th>
                            <th scope="col">Jumlah User</th>
                            <th scope="col">Hak Akses</th>
                            <th scope="col" class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $key => $role)
                            <tr>
                                <th scope="row" class="text-center">{{ $key + 1 }}</th>
                                <td>
                                    {{ $role->label }}
                                    @if ($role->is_admin)
                                        <span class="badge bg-primary ms-1">Akses Penuh</span>
                                    @endif
                                </td>
                                <td>{{ $role->users_count }} user</td>
                                <td>
                                    @if ($role->is_admin)
                                        <span class="text-body-secondary">Semua modul (otomatis)</span>
                                    @elseif ($role->permissions->isEmpty())
                                        <span class="text-body-secondary">Belum ada modul diizinkan</span>
                                    @else
                                        {{ $role->permissions->count() }} modul diizinkan
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-warning text-white" data-coreui-toggle="modal" data-coreui-target="#editRoleModal-{{ $role->id }}" title="Edit Role">
                                        <i class="cil-pencil"></i>
                                    </button>
                                    @if (! $role->is_admin)
                                        <button type="button" class="btn btn-sm btn-danger text-white"
                                                data-coreui-toggle="modal"
                                                data-coreui-target="#deleteConfirmationModal"
                                                data-url="{{ route('role-management.destroy', $role->id) }}"
                                                title="Hapus Role">
                                            <i class="cil-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal Edit Role -->
                            <div class="modal fade" id="editRoleModal-{{ $role->id }}" tabindex="-1" aria-labelledby="editRoleModalLabel-{{ $role->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editRoleModalLabel-{{ $role->id }}">Edit Role — {{ $role->label }}</h5>
                                            <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('role-management.update', $role->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="label-{{ $role->id }}" class="form-label">Nama Role</label>
                                                    <input type="text" class="form-control" id="label-{{ $role->id }}" name="label" value="{{ old('label', $role->label) }}" required>
                                                </div>

                                                @if ($role->is_admin)
                                                    <div class="alert alert-info mb-0">
                                                        Role ini punya akses penuh ke semua modul secara otomatis, jadi hak akses per modul tidak perlu diatur.
                                                    </div>
                                                @else
                                                    <label class="form-label">Hak Akses Modul</label>
                                                    @php $rolePermissionIds = $role->permissions->pluck('id')->all(); @endphp
                                                    @foreach ($permissions as $group => $items)
                                                        <div class="mb-2">
                                                            <div class="fw-semibold small text-uppercase text-body-secondary mb-1">{{ $group }}</div>
                                                            <div class="row">
                                                                @foreach ($items as $permission)
                                                                    <div class="col-md-6">
                                                                        <div class="form-check">
                                                                            <input type="checkbox" class="form-check-input"
                                                                                   id="perm-{{ $role->id }}-{{ $permission->id }}"
                                                                                   name="permissions[]" value="{{ $permission->id }}"
                                                                                   {{ in_array($permission->id, $rolePermissionIds) ? 'checked' : '' }}>
                                                                            <label class="form-check-label" for="perm-{{ $role->id }}-{{ $permission->id }}">
                                                                                {{ $permission->label }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
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
                                <td colspan="5" class="text-center py-4">Belum ada role.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Role -->
<div class="modal fade" id="tambahRoleModal" tabindex="-1" aria-labelledby="tambahRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahRoleModalLabel">Tambah Role Baru</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('role-management.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="label" class="form-label">Nama Role</label>
                        <input type="text" class="form-control" id="label" name="label" value="{{ old('label') }}" placeholder="mis. Staf SBP" required>
                    </div>

                    <label class="form-label">Hak Akses Modul</label>
                    @foreach ($permissions as $group => $items)
                        <div class="mb-2">
                            <div class="fw-semibold small text-uppercase text-body-secondary mb-1">{{ $group }}</div>
                            <div class="row">
                                @foreach ($items as $permission)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                   id="perm-new-{{ $permission->id }}"
                                                   name="permissions[]" value="{{ $permission->id }}">
                                            <label class="form-check-label" for="perm-new-{{ $permission->id }}">
                                                {{ $permission->label }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
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
