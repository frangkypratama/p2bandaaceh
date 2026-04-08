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
                                    @php $truncateCols = ['alasan_penindakan', 'uraian_barang']; @endphp
                                    @foreach ($columns as $column)
                                        @if (in_array($column, $truncateCols) && Str::length($row->$column) > 60)
                                            <td class="truncate-cell">
                                                <div class="truncate-short">{!! nl2br(e(Str::limit($row->$column, 60))) !!}</div>
                                                <div class="truncate-full d-none">{!! nl2br(e($row->$column)) !!}</div>
                                                <button class="btn btn-sm btn-link p-0 btn-toggle-truncate">Selengkapnya</button>
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
    .truncate-cell {
        min-width: 200px;
        max-width: 300px;
        transition: max-width 0.3s ease;
    }
    .truncate-cell.expanded {
        max-width: none;
        white-space: pre-wrap;
        word-break: break-word;
    }
    .truncate-short {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .truncate-full {
        white-space: pre-wrap;
        word-break: break-word;
        line-height: 1.6;
    }
    .btn-toggle-truncate {
        font-size: 0.75rem;
        text-decoration: none;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-toggle-truncate').forEach(btn => {
        btn.addEventListener('click', function () {
            const cell = this.closest('.truncate-cell');
            const short = cell.querySelector('.truncate-short');
            const full = cell.querySelector('.truncate-full');
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