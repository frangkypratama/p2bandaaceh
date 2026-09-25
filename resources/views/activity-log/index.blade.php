@extends('layouts.app')

@section('title', 'Log Aktivitas')

@php
    $actionLabels = [
        'created' => ['Ditambahkan', 'success'],
        'updated' => ['Diubah', 'warning'],
        'deleted' => ['Dihapus', 'danger'],
        'login' => ['Login', 'info'],
        'logout' => ['Logout', 'secondary'],
        'login_failed' => ['Login Gagal', 'danger'],
    ];
@endphp

@section('content')
<div class="container-lg">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0"><strong>Log Aktivitas</strong></h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('activity-log.index') }}" class="row g-2 mb-3">
                <div class="col-md-3">
                    <label class="form-label">Pengguna</label>
                    <select name="user_id" class="form-select">
                        <option value="">Semua Pengguna</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ (string) request('user_id') === (string) $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Aksi</label>
                    <select name="action" class="form-select">
                        <option value="">Semua Aksi</option>
                        @foreach ($actionLabels as $value => [$label, $color])
                            <option value="{{ $value }}" {{ request('action') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Modul</label>
                    <select name="subject_type" class="form-select">
                        <option value="">Semua Modul</option>
                        @foreach ($subjectTypes as $type)
                            <option value="{{ $type }}" {{ request('subject_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="cil-filter"></i>
                    </button>
                </div>
                @if (request()->anyFilled(['user_id', 'action', 'subject_type', 'tanggal_dari', 'tanggal_sampai']))
                    <div class="col-12">
                        <a href="{{ route('activity-log.index') }}" class="btn btn-sm btn-link px-0">Reset filter</a>
                    </div>
                @endif
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 15%;">Waktu</th>
                            <th style="width: 15%;">Pengguna</th>
                            <th style="width: 10%;">Aksi</th>
                            <th style="width: 15%;">Modul</th>
                            <th>Keterangan</th>
                            <th style="width: 8%;" class="text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d-m-Y H:i') }}</td>
                                <td>{{ $log->user->name ?? ($log->action === 'login_failed' ? 'Tidak dikenal' : 'Sistem') }}</td>
                                <td>
                                    @php [$label, $color] = $actionLabels[$log->action] ?? [ucfirst($log->action), 'secondary']; @endphp
                                    <span class="badge bg-{{ $color }}">{{ $label }}</span>
                                </td>
                                <td>{{ $log->subject_type ? $log->subject_type.' #'.$log->subject_id : '-' }}</td>
                                <td>{{ $log->description ?? '-' }}</td>
                                <td class="text-center">
                                    @if (!empty($log->changes))
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-coreui-toggle="modal" data-coreui-target="#logDetailModal-{{ $log->id }}">
                                            <i class="cil-list"></i>
                                        </button>

                                        <div class="modal fade" id="logDetailModal-{{ $log->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Detail Perubahan - {{ $log->subject_type }} #{{ $log->subject_id }}</h5>
                                                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <pre class="mb-0" style="white-space: pre-wrap;">{{ json_encode($log->changes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Belum ada aktivitas yang tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
