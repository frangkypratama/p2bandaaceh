@extends('layouts.app')

@section('title', 'Database')

@section('content')
<div class="container-lg">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('database.database') }}" class="btn btn-sm btn-light me-2" title="Kembali ke daftar tabel">
                    <i class="cil-arrow-left"></i>
                </a>
                <h5 class="mb-0">Tabel: <strong>{{ $tableName }}</strong></h5>
            </div>
            <span class="badge bg-primary">{{ $data->total() }} data</span>
        </div>
        <div class="card-body">
            @if ($data->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="cil-inbox" style="font-size: 3rem;"></i>
                    <p class="mt-2 mb-0">Tabel ini tidak memiliki data.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                @foreach ($columns as $column)
                                    <th class="text-nowrap">{{ $column }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    @foreach ($columns as $column)
                                        @php $isAlasan = strtolower(str_replace('_', ' ', $column)) === 'alasan penindakan'; @endphp

                                        @if ($isAlasan && Str::length($row->$column) > 60)
                                            <td class="alasan-cell">
                                                <div class="alasan-short">{!! nl2br(e(Str::limit($row->$column, 60))) !!}</div>
                                                <div class="alasan-full d-none">{!! nl2br(e($row->$column)) !!}</div>
                                                <button class="btn btn-sm btn-link p-0 btn-toggle-alasan">Selengkapnya</button>
                                            </td>
                                        @else
                                            <td>{!! nl2br(e($row->$column)) !!}</td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($data->hasPages())
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $data->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .alasan-cell {
        min-width: 200px;
        max-width: 300px;
        transition: max-width 0.3s ease;
    }
    .alasan-cell.expanded {
        max-width: none;
        white-space: pre-wrap;
        word-break: break-word;
    }
    .alasan-short {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .alasan-full {
        white-space: pre-wrap;
        word-break: break-word;
        line-height: 1.6;
    }
    .btn-toggle-alasan {
        font-size: 0.75rem;
        text-decoration: none;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-toggle-alasan').forEach(btn => {
        btn.addEventListener('click', function () {
            const cell = this.closest('.alasan-cell');
            const short = cell.querySelector('.alasan-short');
            const full = cell.querySelector('.alasan-full');
            const isExpanded = this.classList.contains('active');

            if (isExpanded) {
                short.classList.remove('d-none');
                full.classList.add('d-none');
                cell.classList.remove('expanded');
                this.classList.remove('active');
                this.textContent = 'Selengkapnya';
            } else {
                short.classList.add('d-none');
                full.classList.remove('d-none');
                cell.classList.add('expanded');
                this.classList.add('active');
                this.textContent = 'Sembunyikan';
            }
        });
    });
});
</script>
@endpush