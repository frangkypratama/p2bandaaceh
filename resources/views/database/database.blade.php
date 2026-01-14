@extends('layouts.app')

@section('content')
<div class="container-lg">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Database Explorer</h4>
            <small class="text-medium-emphasis">Pilih tabel untuk melihat isinya.</small>
        </div>
        <div class="card-body">
            @if (empty($tables))
                <div class="alert alert-warning" role="alert">
                    Tidak ada tabel yang ditemukan di dalam database.
                </div>
            @else
                <div class="list-group">
                    @foreach ($tables as $table)
                        <a href="{{ route('database.table', ['table' => $table]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div class="fw-bold">
                                <i class="cil-storage me-2"></i>
                                {{ $table }}
                            </div>
                            <span class="badge bg-primary rounded-pill">
                                <i class="cil-arrow-right"></i>
                            </span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
