@extends('layouts.app')

@section('title', 'Cache')

@section('content')
<div class="container-lg">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><strong>Cache Sistem</strong></h5>
            <form method="POST" action="{{ route('system-cache.clear') }}" onsubmit="return confirm('Bersihkan seluruh cache aplikasi sekarang?');">
                @csrf
                <button type="submit" class="btn btn-warning">
                    <i class="cil-reload"></i> Bersihkan Cache
                </button>
            </form>
        </div>
        <div class="card-body">
            <p class="text-body-secondary">
                Driver cache aktif: <strong>{{ $cacheDriver }}</strong>.
                Data referensi (satuan, jenis barang, tarif cukai, pelanggaran, pangkat/golongan) dan hak akses role
                di-cache otomatis supaya halaman lebih cepat, dan otomatis diperbarui sendiri setiap ada
                perubahan lewat halaman masing-masing. Tombol di atas hanya diperlukan kalau sewaktu-waktu
                datanya terasa tidak sinkron.
            </p>

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col" class="text-center">Jumlah Baris Ter-cache</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cachedItems as $item)
                            <tr>
                                <td>{{ $item['label'] }}</td>
                                <td class="text-center">{{ $item['jumlah'] }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>Role & Hak Akses</td>
                            <td class="text-center">{{ $rolesCount }} role</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
