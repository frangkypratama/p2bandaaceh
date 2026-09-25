@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><strong>Informasi Akun</strong></h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">NIP (username)</label>
                            <input type="text" class="form-control" value="{{ $user->nip }}" disabled>
                            <div class="form-text">NIP tidak bisa diubah sendiri. Hubungi admin lewat menu User Management kalau perlu diperbaiki.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Petugas Terkait</label>
                            <input type="text" class="form-control" value="{{ $user->petugas->nama ?? 'Tidak ditautkan' }}" disabled>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><strong>Ubah Password</strong></h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update-password') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password" name="current_password" autocomplete="current-password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" autocomplete="new-password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Ubah Password</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
